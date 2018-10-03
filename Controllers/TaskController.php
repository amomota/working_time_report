<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
use App\Role;
use App\Workplace;
use Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

    	$projects = Userproject::where('user_id', Auth::User()->id)
    					->orderBy('start_day', 'desc')
    					->get();
		foreach ($projects as $project) {
			$temp_project = Project::where('id', $project->project_id)->first();
			$temp_role = Role::where('id', $project->role_id)->first();
                        $temp_workplace = Workplace::where('id', $project->workplace_id)->first();
			$project->projname = $temp_project->name;
                        $project->rolename = $temp_role->name;
                        $project->workplacename = $temp_workplace->name;
		}
        return view('taskslist')->with('projects', $projects);
    }

    public function batchAdd(Request $request) {
//        if (Auth::User()->isadmin) {
//            return redirect()->to('/admin');
//        }
        $projects = Project::all();
        $roles = Role::all();
        $workplaces = Workplace::all();
        if (Auth::User()->isadmin) {
            $userproject = Userproject::where('user_id', $request->userId)->orderBy('created_at', 'desc')->first();
            $userid = $request->userId;
            return view('batchadd')->with(compact('projects', $projects, 'roles', $roles, 'workplaces', $workplaces, 'userproject', $userproject, 'userid', $userid));
        } else {
            $userproject = Userproject::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->first();
            return view('batchadd')->with(compact('projects', $projects, 'roles', $roles, 'workplaces', $workplaces, 'userproject', $userproject));
        }

    }


    public function batchSave(Request $request) {

	$day_array = explode(';', $request->day_list);
	foreach($day_array as $current_day) {
            $userproject = new Userproject;
            if (Auth::User()->isadmin) {
                $userproject->user_id = $request->userId;
            } else {
                $userproject->user_id = Auth::User()->id;
            }
            $userproject->project_id = '9999';
            $userproject->role_id = 9999;
            $userproject->workplace_id = '9999';
   //         $userproject->start_day = $current_day->format('Y-m-d');
            $userproject->start_day = $current_day;
            $userproject->start_time = '-';
            $userproject->finish_time = '-';
   //         $userproject->finish_day = $current_day->format('Y-m-d');
            $userproject->finish_day = $current_day;
            $userproject->lunch_time = '0';
            $userproject->duration = '-';
            $userproject->late = '0';
            $userproject->late_reason = $request->leave_reason;
            $userproject->ip_info = \Request::ip();

            $userproject->save();
        }

        if (Auth::User()->isadmin) {
//            $users = User::where('id',$request->userId)->get();
//            $projects = Userproject::where('user_id', $request->userId)->orderBy('created_at', 'desc')->get();
//            return view('taskslist')->with(compact('projects', $projects, 'users', $users));

              return redirect()->action( 'AdminController@userTasks',$request->userId);
        }

        return redirect()->to('taskslist');

    }
}
