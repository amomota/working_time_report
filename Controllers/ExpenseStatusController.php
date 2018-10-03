<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userproject;
use App\Project;
use App\Role;
use App\Workplace;
use App\Expense;
use App\Expense_flag;
use Auth;

class ExpenseStatusController extends Controller
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

        // 該当ユーザIDの当月分情報を取得
        $year = date('Y'); //今年を取得
        $month = date('n'); //今月を取得

    	$users = User::orderBy('aiueo_rder','ASC')->get();

        // 今月分の入力ステータス
        $eflgs = Expense_flag::where([
                                       ['year', $year],
                                       ['month', $month],
                                     ])->get();

    	foreach ($users as $key => $user) {
	    if ($user->id == Auth::User()->id) {
    		unset($users[$key]);
    	    }
    	}

        return view('/expense/expensestatus')->with(compact('users', $users,
                                                   'eflgs', $eflgs,
                                                   'year', $year,
                                                   'month', $month));

    }

    public function redraw(Request $request){

        // 指定の年月情報を取得
        $year = $request->expenses_year;
        $month = $request->expenses_month;

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // ユーザ取得
        $users = User::orderBy('aiueo_rder','ASC')->get();

        // 今月分の入力ステータス
        $eflgs = Expense_flag::where([
                                       ['year', $year],
                                       ['month', $month],
                                     ])->get();

//        foreach ($users as $key => $user) {
//            if ($user->id == Auth::User()->id) {
//                unset($users[$key]);
//            }
//        }

        return view('/expense/expensestatus')->with(compact('users', $users,
                                                   'eflgs', $eflgs,
                                                   'year', $year,
                                                   'month', $month));
    }
}
