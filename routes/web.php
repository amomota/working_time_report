<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

Route::post('/start-project', 'HomeController@startProject');

Route::get('/taskslist', 'TaskController@index');

Route::get('/userproject/{projId}', function($projId){
	
	$userproject = App\Userproject::where('id', $projId)->firstOrFail();
	$project = App\Project::where('id', $userproject->project_id)->firstOrFail();
	$role = App\Role::where('id', $userproject->role_id)->firstOrFail();
	$workplace = App\Workplace::where('id', $userproject->workplace_id)->firstOrFail();
	$userproject->project_name = $role->name;
	$userproject->role_name = $project->name;
	$userproject->workplace_name = $workplace->name;
	if (Auth::User()->isadmin || $userproject->user_id == Auth::User()->id) {
		return view('showproject')->with('userproject', $userproject);
	}
});

Route::get('/userproject/edit/{projId}', 'HomeController@editProject');
Route::post('/userproject/save/{projId}', 'HomeController@updateProject');
Route::get('/userproject/delete/{projId}', 'HomeController@deleteProject');

Route::get('/admin', 'AdminController@index');
Route::get('/usertasks/{userId}', 'AdminController@userTasks');

Route::get('/batchadd', 'TaskController@batchAdd');
Route::get('/batchadd/{userId}', 'TaskController@batchAdd');
Route::post('/batchsave', 'TaskController@batchSave');
Route::post('/batchsave/{userId}', 'TaskController@batchSave');

Route::get('/export/exportexcel', 'ExportController@index');
Route::get('/export/exportexcel/{userId}', 'ExportController@index');
Route::post('/export/exportexcel_confirm', 'ExportController@exportexcel_start');
Route::post('/export/exportexcel_confirm/{userId}', 'ExportController@exportexcel_start');
Route::get('/export/bulk_export_work_report', 'ExportController@blk_exp_wr_index');
Route::post('/export/bulk_export_work_report_start', 'ExportController@blk_exp_wr_start');

Route::get('/totalwork', 'TotalWorksController@index');

Route::get('/expense/expenses_processing', 'ExpensesController@index');
Route::get('/expense/expenses_processing/{userId}', 'ExpensesController@index');
Route::get('/expense/expenses_user_detail/{yeAr}/{monTh}', 'ExpensesController@user_detail');
Route::get('/expense/expenses_user_detail/{userId}/{yeAr}/{monTh}', 'ExpensesController@user_detail');
Route::post('/expense/expenses_redraw', 'ExpensesController@redraw');
Route::post('/expense/expenses_redraw/{userId}', 'ExpensesController@redraw');
Route::get('/expense/expensesadd', 'ExpensesController@record_add');
Route::get('/expense/expensesadd/{userId}', 'ExpensesController@record_add');
Route::post('/expense/expensesstore', 'ExpensesController@record_store');
Route::post('/expense/expensesstore/{userId}', 'ExpensesController@record_store');
Route::get('/expense/delete/{projId}/{daTe}', 'ExpensesController@record_delete');
Route::get('/expense/edit/{projId}', 'ExpensesController@record_edit');
Route::post('/expense/save/{projId}', 'ExpensesController@record_update');
Route::get('/expense/confirm/{userId}/{yeAr}/{monTh}', 'ExpensesController@confirm');
Route::get('/expense/confirm/{yeAr}/{monTh}', 'ExpensesController@confirm');
Route::get('/expense/confirm_cancel/{userId}/{yeAr}/{monTh}', 'ExpensesController@confirm_cancel');
Route::get('/expense/confirm_cancel/{yeAr}/{monTh}', 'ExpensesController@confirm_cancel');
Route::get('/expense/expense_status', 'ExpenseStatusController@index');
Route::post('/expense/expense_status/redraw', 'ExpenseStatusController@redraw');
Route::get('/expense/nokia_expensesadd', 'ExpensesController@nokia_record_add');
Route::get('/expense/nokia_expensesadd/{userId}', 'ExpensesController@nokia_record_add');
Route::post('/expense/nokia_expensesstore', 'ExpensesController@nokia_record_store');
Route::post('/expense/nokia_expensesstore/{userId}', 'ExpensesController@nokia_record_store');
Route::get('/nokia_expense/edit/{userId}/{yeAr}/{monTh}', 'ExpensesController@nokia_record_edit');
Route::post('/nokia_expense/save/{Id}', 'ExpensesController@nokia_record_update');

Route::get('/user/userprofile/{userId}', 'UserProfileController@index');
Route::get('/user/userprofile/edit/{userId}', 'UserProfileController@profile_edit');
Route::post('/user/userprofile/save/{userId}', 'UserProfileController@profile_update');
Route::get('/user/userprofile/delete/{userId}', 'UserProfileController@profile_delete');
Route::get('/user/signup', 'SignUpController@signup_input');
Route::post('/user/signupstore', 'SignUpController@store');

Auth::routes();
