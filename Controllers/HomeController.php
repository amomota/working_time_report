<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Userproject;
use App\Project;
use App\Role;
use App\Workplace;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::User()->isadmin) {
            return redirect()->to('/admin');
        }
        $projects = Project::all();
        $roles = Role::all();
        $workplaces = Workplace::all();
        $userproject = Userproject::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->first();
        // dd($userproject);
        if(!$userproject) {
            $userproject = (object)null;//new stdClass();
            $userproject->lunch_time = 3;
            $userproject->project_id = null;
            $userproject->role_id = null;
            $userproject->workplace_id = null;
        }

        return view('home')->with(compact('projects', $projects, 'roles', $roles, 'workplaces', $workplaces, 'userproject', $userproject));
    }

    public function startProject(Request $request) {
        $userproject = new Userproject;

        $userproject->user_id = Auth::User()->id;
        $userproject->project_id = $request->project;
        $userproject->role_id = $request->role;
        $userproject->workplace_id = $request->workplace;
        $userproject->start_day = $request->start_day;
        $userproject->start_time = $request->start_time;
        $userproject->finish_time = $request->finish_time;
        $userproject->finish_day = $request->finish_day;
        $userproject->lunch_time = $request->lunch_time;
        $userproject->duration = $request->duration;
        $userproject->late = $request->late_chck ? 1 : 0;
        $userproject->late_reason = $request->late_reason;

        $userproject->save();

        return redirect()->to('taskslist');
    }

    public function editProject(Request $request) {

            if (Auth::User()->isadmin) {

                $userproject = Userproject::where('id', $request->projId)->firstOrFail();
                $allprojects = Project::all();
                $allroles = Role::all();
        	    $allworkplaces = Workplace::all();

                return view('editproject')->with( array(
                    'allprojects' => $allprojects,
                    'allroles' => $allroles,
                    'allworkplaces' => $allworkplaces,
                    'userproject' => $userproject
                    ));

            } else {
                $userproject = Userproject::where('id', $request->projId)
                                ->where('user_id', Auth::User()->id)
                                ->firstOrFail();
                $allprojects = Project::all();
                $allroles = Role::all();
                $allworkplaces = Workplace::all();

                return view('editproject')->with( array(
                    'allprojects' => $allprojects,
                    'allroles' => $allroles,
                    'allworkplaces' => $allworkplaces,
                    'userproject' => $userproject
                    ));
            }
    }

    public function updateProject(Request $request) {
        $userproject = Userproject::where('id', $request->projId)->firstOrFail();
        $userproject->project_id = $request->project;
        $userproject->role_id = $request->role;
        $userproject->workplace_id = $request->workplace;
        $userproject->start_day = $request->start_day;
        $userproject->start_time = $request->start_time;
        $userproject->finish_time = $request->finish_time;
        $userproject->lunch_time = $request->lunch_time;
        $userproject->duration = $request->duration;
        $userproject->late = $request->late_chck ? 1 : 0;
        $userproject->late_reason = $request->late_reason;

        $userproject->save();
	if (Auth::User()->isadmin) {
        	return redirect()->to('/usertasks/'.$userproject->user_id);
	} else{
		return redirect()->to('taskslist');
	}
    }

    public function deleteProject(Request $request) {
        $userproject = Userproject::where('id', $request->projId)->firstOrFail();
        Userproject::destroy($request->projId);

        if (Auth::User()->isadmin) {
                return redirect()->to('/usertasks/'.$userproject->user_id);
        } else{
                return redirect()->to('taskslist');
        }
    }
}
