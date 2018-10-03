<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

        $this->validate($request,[
            'project' => 'required',
        ]);

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
        $userproject->ip_info = \Request::ip();

        $userproject->save();

        return redirect()->to('taskslist');
    }

    public function editProject(Request $request) {

        $userproject = Userproject::where('id', $request->projId)->firstOrFail();
        $allprojects = Project::where('disable','1')->orderBy('name')->get();
        $allroles = Role::all();
        $allworkplaces = Workplace::all();

        if (Auth::User()->isadmin) {
            $user = User::where('id',Auth::User()->id)->firstOrFail();
        }else{
            $user = User::where('id',$userproject->user_id)->firstOrFail();
        }

        // ブラックリスト対象者は編集をすることができない
        if($user->blacklist){
            return response('編集処理が行えません。修正が必要な場合は、管理者もしくは加茂まで連絡願います。',200)->header('Content-Type', 'text/plain');
        }else{
            return view('editproject')->with( array(
                                                'allprojects' => $allprojects,
                                                'allroles' => $allroles,
                                                'allworkplaces' => $allworkplaces,
                                                'userproject' => $userproject
                                               ));
        }

    }

    public function updateProject(Request $request) {

        $this->validate($request,[
            'project' => 'required',
        ]);

        $userproject = Userproject::where('id', $request->projId)->firstOrFail();

        // ロギング出力に必要な情報を取得
        $logging_path = "/var/www/html/temp/storage/logs/mod_logging.log";
        $today = date('Y-m-d H:i:s');
        $temp_user = User::where('id',$userproject->user_id)->first();
        $temp_rolename = Role::where('id', $userproject->role_id)->first();
        $temp_workplacename =Workplace::where('id', $userproject->workplace_id)->first();

        // 管理者と一般ユーザでコメントを分岐
        if (Auth::User()->isadmin) {
            error_log($today . " に 管理者 が " . $temp_user->name . " の勤怠を変更しました" .
                       "\n", 3, $logging_path);
        } else {
            error_log($today . " に " . $temp_user->name . " が " . $temp_user->name . " の勤怠を変更しました" .
                       "\n", 3, $logging_path);
        }

        // 変更前のログ取得
        error_log("変更前：" .
                  $userproject->project_id .   "\t" .
                  $userproject->start_day .    "\t" .
                  $userproject->start_time .   "\t" .
                  $userproject->finish_day .   "\t" .
                  $userproject->finish_time .  "\t" .
                  $temp_rolename->name .       "\t" .
                  $temp_workplacename->name .  "\t" .
                  $userproject->late_reason .  "\t" .
                  "\n",
                  3, $logging_path
                 );

        $userproject->project_id = $request->project;
        $userproject->role_id = $request->role;
        $userproject->workplace_id = $request->workplace;
        $userproject->start_day = $request->start_day;
        $userproject->start_time = $request->start_time;
        $userproject->finish_day = $request->finish_day;
        $userproject->finish_time = $request->finish_time;
        $userproject->lunch_time = $request->lunch_time;
        $userproject->duration = $request->duration;
        $userproject->late = $request->late_chck ? 1 : 0;
        $userproject->late_reason = $request->late_reason;

        $temp2_rolename = Role::where('id', $userproject->role_id)->first();
        $temp2_workplacename =Workplace::where('id', $userproject->workplace_id)->first();

        // 変更後のログを取得
        error_log("変更後：" .
                  $userproject->project_id .   "\t" .
                  $userproject->start_day .    "\t" .
                  $userproject->start_time .   "\t" .
                  $userproject->finish_day .   "\t" .
                  $userproject->finish_time .  "\t" .
                  $temp2_rolename->name .      "\t" .
                  $temp2_workplacename->name . "\t" .
                  $userproject->late_reason .  "\t" .
                  "\n\n",
                  3, $logging_path
                 );

        // データベースへ保存
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
