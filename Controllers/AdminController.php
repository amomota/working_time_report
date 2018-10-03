<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
use App\Role;
use App\Workplace;
use App\Via;
use App\Affiliation;
use App\Team;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        if (!Auth::User()->isadmin) {
            abort(404);
        }

    	$users = User::orderBy('aiueo_rder','ASC')->get();
        $vias = Via::all();
        $affiliations = Affiliation::all();
        $teams = Team::all();

        // ミナト正社員 計上処理
        $isregularemployee_count = User::where([ ['isadmin','0'], ['isactive','1'], ['isregularemployee','1'] ])->count();   // 正社員

    	foreach ($users as $key => $user) {
	    if ($user->id == Auth::User()->id) {
    		unset($users[$key]);
    	    }
    	}

    	return view('mainadmin')->with(compact('users', $users,
                                               'vias', $vias,
                                               'affiliations', $affiliations,
                                               'teams', $teams,
                                               'isregularemployee_count', $isregularemployee_count));

    }

    public function userTasks(Request $request) {
        if (!Auth::User()->isadmin) {
            abort(404);
        }
    	$projects = Userproject::where('user_id', $request->userId)
    					->orderBy('start_day', 'desc')
    					->get();
		foreach ($projects as $project) {
			$temp = Project::where('id', $project->project_id)->first();
                        $temp_role = Role::where('id', $project->role_id)->first();
                        $temp_workplace = Workplace::where('id', $project->workplace_id)->first();
			$project->projname = $temp->name;
                        $project->rolename = $temp_role->name;
                        $project->workplacename = $temp_workplace->name;
		}

        $users = User::where('id',$request->userId)->get();

    	return view('taskslist')->with(compact('projects', $projects, 'users', $users));
    }

    public function changeDate(Request $request) {
        if (!Auth::User()->isadmin) {
            abort(404);
        }

        $users = User::orderBy('aiueo_rder','ASC')->get();
        $workplaces = Workplace::all();
//        $projects = Userproject::orderBy('start_day','DESC')->get();
        $projects = Userproject::where('start_day',$request->day_list)->orderBy('start_day','DESC')->get();

        foreach ($users as $key => $user) {
            if ($user->id == Auth::User()->id) {
                unset($users[$key]);
            }
        }

        $target_date = $request->day_list;

        return view('mainadmin')->with(compact('users', $users, 'projects', $projects, 'workplaces', $workplaces, 'target_date', $target_date));
    }
}
