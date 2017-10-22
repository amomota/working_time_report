<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if (Auth::User()->isadmin) {
            return redirect()->to('/admin');
        }
        $projects = Project::all();
        $roles = Role::all();
        $workplaces = Workplace::all();
        $userproject = Userproject::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->first();

        return view('batchadd')->with(compact('projects', $projects, 'roles', $roles, 'workplaces', $workplaces, 'userproject', $userproject));
    }

    public function batchSave(Request $request) {

$output = new \Symfony\Component\Console\Output\ConsoleOutput();

$output->writeln('hello');

$output2 = new \Symfony\Component\Console\Output\ConsoleOutput(2);

$output2->writeln('hello2');

//$output3 = new Symfony\Component\Console\Output\ConsoleOutput();

//$output3->writeln('hello3');
//$output4 = new symfony\Component\Console\Output\ConsoleOutput();

//$output4->writeln('hello4');

//$output5 = new Symfony\Component\Console\Output\ConsoleOutput(2);

//$output5->writeln('hello5');

//$output6 = new symfony\Component\Console\Output\ConsoleOutput(2);

//$output6->writeln('hello6');



//$output = new symfony\console\Output\ConsoleOutput();
//$output->writeln("<info>Error message</info>");
//	$day_array = explode(';', $request->day_list);
//	foreach($day_array as $current_day) {
 //           $userproject = new Userproject;
 //$current_day = $request->day_list;
   //         $userproject->user_id = Auth::User()->id;
   //         $userproject->project_id = $request->project;
   //         $userproject->role_id = $request->role;
   //         $userproject->workplace_id = $request->workplace;
   //         $userproject->start_day = $current_day->format('Y-m-d');
   //         $userproject->start_time = $request->start_time;
   //         $userproject->finish_time = $request->finish_time;
   //         $userproject->finish_day = $current_day->format('Y-m-d');
   //         $userproject->lunch_time = $request->lunch_time;
   //         $userproject->duration = $request->duration;
   //         $userproject->late = 0;
   //         $userproject->late_reason = '';

   //         $userproject->save();
   //     }
        return redirect()->to('taskslist');
    }
}
