<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
use App\Role;
use App\Workplace;
use Auth;

class TotalWorksController extends Controller
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

        // 月初めと月終わりを取得
        $startDate = date('Y-m-01');                            // 月初め
        $endDate = date('Y-m-t');                               // 月終わり
        $laststartDate = date('Y-m-01', strtotime("-1 month")); // 1ヶ月前の月初め
        $lastendDate = date('Y-m-t', strtotime("-1 month"));    // 1ヶ月前の月終わり
        $secondstartDate = date('Y-m-01', strtotime("-2 month"));  // 2ヶ月前の月初め
        $secondendDate = date('Y-m-t', strtotime("-2 month"));     // 2ヶ月前の月終わり
        $thirdstartDate = date('Y-m-01', strtotime("-3 month"));  // 3ヶ月前の月初め
        $thirdendDate = date('Y-m-t', strtotime("-3 month"));     // 3ヶ月前の月終わり
        $forthstartDate = date('Y-m-01', strtotime("-4 month"));  // 4ヶ月前の月初め
        $forthendDate = date('Y-m-t', strtotime("-4 month"));     // 4ヶ月前の月終わり
        $fivestartDate = date('Y-m-01', strtotime("-5 month"));  // 5ヶ月前の月初め
        $fiveendDate = date('Y-m-t', strtotime("-5 month"));     // 5ヶ月前の月終わり
        $sixstartDate = date('Y-m-01', strtotime("-6 month"));  // 6ヶ月前の月初め
        $sixendDate = date('Y-m-t', strtotime("-6 month"));     // 6ヶ月前の月終わり

        // admin権限以外のユーザを取得
//    	$users = User::orderBy('aiueo_rder','ASC')->get();
    	$users = User::where([ ['isadmin','0'],
                               ['isactive','1'],
                             ])->orderBy('aiueo_rder','ASC')->get();

        // admin権限以外のユーザをカウント
        $users_count = User::where([
                                     ['isadmin','0'],
                                     ['isactive','1'],
                                   ])->count();

        // 箕輪(admin)は対象外に設定
    	foreach ($users as $key => $user) {
	    if ($user->id == Auth::User()->id) {
   		unset($users[$key]);
    	    }
    	}

        // 総作業時間を設定
        $cnt_i = 0;
        $month_works = [];

        foreach ($users as $user) {
            $cnt_j = 0;
            if($user->isadmin == 0){
                $month_works[$cnt_i][$cnt_j] = $user->id;
                $last_month_works[$cnt_i][$cnt_j] = $user->id;
                $second_month_works[$cnt_i][$cnt_j] = $user->id;
                $third_month_works[$cnt_i][$cnt_j] = $user->id;
                $forth_month_works[$cnt_i][$cnt_j] = $user->id;
                $five_month_works[$cnt_i][$cnt_j] = $user->id;
                $six_month_works[$cnt_i][$cnt_j] = $user->id;

                $cnt_j = $cnt_j + 1;

                $month_works[$cnt_i][$cnt_j] = $user->name;
                $last_month_works[$cnt_i][$cnt_j] = $user->name;
                $second_month_works[$cnt_i][$cnt_j] = $user->name;
                $third_month_works[$cnt_i][$cnt_j] = $user->name;
                $forth_month_works[$cnt_i][$cnt_j] = $user->name;
                $five_month_works[$cnt_i][$cnt_j] = $user->name;
                $six_month_works[$cnt_i][$cnt_j] = $user->name;

                $cnt_j = $cnt_j + 1;

                $month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$startDate,$endDate])
                                                         ->sum('duration');
                $last_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$laststartDate,$lastendDate])
                                                         ->sum('duration');
                $second_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$secondstartDate,$secondendDate])
                                                         ->sum('duration');
                $third_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$thirdstartDate,$thirdendDate])
                                                         ->sum('duration');
                $forth_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$forthstartDate,$forthendDate])
                                                         ->sum('duration');
                $five_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$fivestartDate,$fiveendDate])
                                                         ->sum('duration');
                $six_month_works[$cnt_i][$cnt_j] = Userproject::where('user_id', $user->id )
                                                         ->whereBetween('start_day',[$sixstartDate,$sixendDate])
                                                         ->sum('duration');

                $cnt_i = $cnt_i + 1;
            }
        }


    	return view('totalwork')->with(compact('users', $users,                           // Admin以外のユーザ
                                               'month_works', $month_works,               // 当月総作業時間
                                               'last_month_works', $last_month_works,     // 1ヶ月前の総作業時間
                                               'second_month_works', $second_month_works, // 2ヶ月前の総作業時間
                                               'third_month_works', $third_month_works,   // 3ヶ月前の総作業時間
                                               'forth_month_works', $forth_month_works,   // 4ヶ月前の総作業時間
                                               'five_month_works', $five_month_works,     // 5ヶ月前の総作業時間
                                               'six_month_works', $six_month_works,       // 6ヶ月前の総作業時間
                                               'users_count', $users_count));

    }

}
