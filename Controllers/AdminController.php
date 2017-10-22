<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
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

    	$users = User::all();
    	foreach ($users as $key => $user) {
    		if ($user->id == Auth::User()->id) {
    			unset($users[$key]);
    		}
    	}
    	return view('mainadmin')->with('users', $users);
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
			$project->projname = $temp->name;
		}
    	return view('taskslist')->with('projects', $projects);
    }
}
