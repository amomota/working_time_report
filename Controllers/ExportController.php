<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
use Auth;

class ExportController extends Controller
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
    public function index(Request $request)
    {
        // 該当ユーザIDの当年分データを取得
        $year = date('Y'); //今年を取得

        if (Auth::User()->isadmin) {
            $userid = $request->userId;
            return view('/export/exportexcel')->with(compact('userid',$userid,
                                                     'year',$year));
        } else {
            return view('/export/exportexcel')->with('year',$year);
        }
    }

    public function exportexcel_start(Request $request) {
        $user_id = Auth::User()->id;
        $export_year = $request->export_year;
        $export_month = $request->export_month;
        $session_id = session()->getId();

        $post=($_POST['gender']);

        $userName = null;
        if (Auth::User()->isadmin) {
            $users = User::where('id', $request->userId )->get();
        } else {
            $users = User::where('id', $user_id )->get();
        }
        foreach ($users as $user) {
            $userName = str_replace(" ", "", $user->name);
        }

        if($post=='ost'){
            if (Auth::User()->isadmin) {
                exec("export LANG=\"en_US.UTF-8\";
                      cd /var/www/html/temp/tool;
                      java -Dfile.encoding=UTF-8 -jar timesheet_export_v1.5.jar $request->userId $session_id  $export_month $export_year"
                    );
            } else {
                exec("export LANG=\"en_US.UTF-8\";
                      cd /var/www/html/temp/tool;
                      java -Dfile.encoding=UTF-8 -jar timesheet_export_v1.5.jar $user_id $session_id  $export_month $export_year"
                    );
            }

            $filename = $userName . "_" . $export_year . "_" . $export_month . "_timesheet.xls";

        }else{
            if (Auth::User()->isadmin) {
                exec("export LANG=\"en_US.UTF-8\";
                      cd /var/www/html/temp/tool/minato_t_report;
                      java -Dfile.encoding=UTF-8 -jar timesheet_export_minato_v1.4.jar $request->userId $session_id  $export_month $export_year"
                    );
            } else {
                exec("export LANG=\"en_US.UTF-8\";
                      cd /var/www/html/temp/tool/minato_t_report;
                      java -Dfile.encoding=UTF-8 -jar timesheet_export_minato_v1.4.jar $user_id $session_id  $export_month $export_year"
                    );
            }

            $filename =$userName . "_" . $export_year . "_" . $export_month . "_timesheet_minato.xls";

        }

        $filepath= public_path() . "/download/" . $session_id . "/" . $filename;

        $headers = array(
                      'Content-Type: application/vnd.ms-excel',
                        );

        return response()->download($filepath, $filename, $headers);

    }

    public function blk_exp_wr_index()
    {
        // 年(今年)を取得
        $year  = date('Y'); //今年を取得
        $month = date('n'); //月を取得

        return view('/export/blkexpworkrepo')->with(compact('year',$year,
                                                            'month',$month));
    }

    public function blk_exp_wr_start(Request $request) {
        $export_year = $request->export_year;
        $export_month = $request->export_month;
        $session_id = session()->getId();
        $post=($_POST['gender']);

        if($post=='ost'){
            exec("export LANG=\"en_US.UTF-8\";
                  cd /var/www/html/temp/tool;
                  java -Dfile.encoding=UTF-8 -jar timesheet_export_v1.5.jar OST $session_id  $export_month $export_year");

            $filename = $export_year . "_" . $export_month . "_OST_timesheets.zip";

        } elseif($post=='employee') {
            exec("export LANG=\"en_US.UTF-8\";
                  cd /var/www/html/temp/tool/minato_t_report;
                  java -Dfile.encoding=UTF-8 -jar timesheet_export_minato_v1.4.jar MINATO $session_id  $export_month $export_year");

            $filename = $export_year . "_" . $export_month . "_Minato_timesheets.zip";

        } else {
            exec("export LANG=\"en_US.UTF-8\";
                  cd /var/www/html/temp/tool/minato_t_report;
                  java -Dfile.encoding=UTF-8 -jar timesheet_export_minato_v1.4.jar ALL  $session_id  $export_month $export_year");

            $filename = $export_year . "_" . $export_month . "_All_timesheets.zip";

        }

        $filepath = public_path() . "/download/" . $session_id . "/" . $filename;

        $headers = array(
                      'Content-Type: application/vnd.ms-excel',
                        );

        return response()->download($filepath, $filename, $headers);

    }
}
