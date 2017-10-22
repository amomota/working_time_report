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
Route::post('/batchsave', 'TaskController@batchSave');

Route::get('/exportexcel', 'ExportController@index');

Route::post('/exportexcel_confirm', 'ExportController@exportexcel_start');


Auth::routes();
