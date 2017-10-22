<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function index()
    {
        return view('exportexcel');
    }

	public function exportexcel_start(Request $request) {
        $user_id = Auth::User()->id;
		$export_year = $request->export_year;
		$export_month = $request->export_month;
$session_id = session()->getId();
exec("cd /var/www/html/temp/tool;java -jar timesheet_export_v1.0.jar $user_id $session_id  $export_month $export_year");
	 /**	$process = new Process('touch testttttttttttttttttttttttttt');
	*	$process->run();
*
*		if (!$process->isSuccessful()) {
*			throw new ProcessFailedException($process);
*		}
*        return view('exportexcel');
*/
$filename = $export_year . "_" . $export_month . "_timesheet.xls";
    $filepath= public_path() . "/download/" . $session_id . "/" . $filename;

    $headers = array(
              'Content-Type: application/vnd.ms-excel',
            );

    return response()->download($filepath, $filename, $headers);
}

}
