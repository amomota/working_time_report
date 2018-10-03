<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Expense;
use App\Expense_flag;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        // 該当ユーザIDの当月分データを取得
        $year = date('Y'); //今年を取得
        $month = date('n'); //今月を取得

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // 確定フラグ取得 (non-object caseを考慮)
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // NOKIA経費合計額取得
        $nokia_total_price = $expenseflg->nokia_total_price;
                                         
        // 当月の経費取得
        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;


        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();



        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));
    }

    public function redraw(Request $request){

        $year = $request->expenses_year;
        $month = $request->expenses_month;

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // NOKIA経費合計額取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        // リストで指定した年月の経費取得
        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // ミナト経費合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // ミナト経費合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg',$eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));
    }

    public function record_add(Request $request)
    {

        if(Auth::User()->isadmin){
            $expenses = Expense::where('user_id', $request->userId)->orderBy('created_at', 'desc')->first();
            $userid = $request->userId;
        }else{
            $expenses = Expense::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->first();
            $userid = Auth::User()->id;
        }

        if(!$expenses){
            $expenses = (object)null;//new stdClass();
        }

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenseadd')->with(compact('expenses', $expenses,
                                                'users', $users));
    }


    public function record_store(Request $request){

        $day_array = explode(';', $request->start_day);
        foreach($day_array as $current_day) {
            $expense = new Expense;
            if(Auth::User()->isadmin){
                $userid = $request->userId;
            }else{
                $userid = Auth::User()->id;
            }
            $expense->user_id = $userid;
//            $expense->date = $request->start_day;
            $expense->date = $current_day;
            $expense->transportation_fee = $request->transportation_fee;
            $expense->departure = $request->departure;
            $expense->arrival = $request->arrival;
            $expense->petrol = $request->petrol;
            $expense->parking = $request->parking;
            $expense->accommodation = $request->accommodation;
            $expense->allowance = $request->allowance;
            $expense->other = $request->other;
            $expense->description = $request->description;

            $expense->save();
        }

        list($year, $month, $day) = explode("-", $request->start_day);

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // Nokia経費合計を取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));

          return redirect()->to('/expense/expenses_redraw/'.$userid);
    }

    public function record_delete(Request $request){

        $expense = Expense::where('id', $request->projId)->firstOrFail();

        if(Auth::User()->isadmin){
            $userid = $expense->user_id;
        }else{
            $userid = Auth::User()->id;
        }

        Expense::destroy($request->projId);

        list($year, $month, $day) = explode("-", $request->daTe);

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // Nokia経費合計を取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'total_price', $total_price,
                                                 'year', $year,
                                                 'month',$month,
                                                 'userid', $userid,
                                                 'users', $users));

    }


    public function record_edit(Request $request){

        $expense = Expense::where('id', $request->projId)->firstOrFail();

        if(Auth::User()->isadmin){
            $userid = $expense->user_id;
        }else{
            $userid = Auth::User()->id;
        }
        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenseedit')->with(compact('expense', $expense,
                                                 'users',$users));
    }



    public function record_update(Request $request){

        $expense = Expense::where('id', $request->projId)->firstOrFail();

        if(Auth::User()->isadmin){
            $userid = $expense->user_id;
        }else{
            $userid = Auth::User()->id;
        }

        $expense->date = $request->start_day;
        $expense->transportation_fee = $request->transportation_fee;
        $expense->departure = $request->departure;
        $expense->arrival = $request->arrival;
        $expense->petrol = $request->petrol;
        $expense->parking = $request->parking;
        $expense->accommodation = $request->accommodation;
        $expense->allowance = $request->allowance;
        $expense->other = $request->other;
        $expense->description = $request->description;

        $expense->save();

        list($year, $month, $day) = explode("-", $request->start_day);

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // Nokia経費合計を取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));

    }

    public function confirm(Request $request){


        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$request->yeAr], ['month',$request->monTh] ])->first();

        $expenseflg->user_id = $userid;
        $expenseflg->year = $request->yeAr;
        $expenseflg->month = $request->monTh;
        if( $expenseflg->isconfirm == 0 ){
            $expenseflg->isconfirm = 1;
            $eflg = 1;
        }else{
            $expenseflg->isconfirm = 0;
            $eflg = 0;
        }

        $expenseflg->save();

        // Nokia経費合計を取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        $year = $request->yeAr;
        $month = $request->monTh;

        $expenses = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                     ->whereYear('date',$request->yeAr)->whereMonth('date',$request->monTh)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                             'eflg',$eflg,
                                             'subtotal_transportation_fee', $subtotal_transportation_fee,
                                             'subtotal_petrol', $subtotal_petrol,
                                             'subtotal_parking', $subtotal_parking,
                                             'subtotal_accommodation', $subtotal_accommodation,
                                             'subtotal_allowance', $subtotal_allowance,
                                             'subtotal_other', $subtotal_other,
                                             'total_price', $total_price,
                                             'nokia_total_price', $nokia_total_price,
                                             'year', $year,
                                             'month', $month,
                                             'userid', $userid,
                                             'users', $users));

    }

    public function nokia_record_add(Request $request)
    {

        // 該当ユーザIDの当月分データを取得
        $year = date('Y'); //今年を取得
        $month = date('n'); //今月を取得

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/nokia_expenseadd')->with(compact('users', $users,
                                                                     'year' , $year,
                                                                     'month', $month));
    }

    public function nokia_record_store(Request $request){

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([
                                              ['user_id', $userid],
                                              ['year',$request->nokia_expenses_year],
                                              ['month',$request->nokia_expenses_month] ]
                                            )->first();

        $expense_flag->nokia_total_price = $request->nokia_total_price;
        $expense_flag->save();


        $year= $request->nokia_expenses_year;
        $month= $request->nokia_expenses_month;

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // NOKIA経費合計額取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        // ミナト経費取得
        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // ミナト経費合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // ミナト経費の合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        
        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));

    }

    public function nokia_record_edit(Request $request){


        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        $expense = Expense_flag::where([ ['user_id', $userid], ['year',$request->yeAr], ['month',$request->monTh] ])->first();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/nokia_expenseedit')->with(compact('expense', $expense,
                                                                     'users',$users));
    }

    public function nokia_record_update(Request $request){

        $expense = Expense_flag::where('id', $request->Id)->firstOrFail();

        if(Auth::User()->isadmin){
            $userid = $expense->user_id;
        }else{
            $userid = Auth::User()->id;
        }

        $expense->nokia_total_price = $request->nokia_total_price;

        $expense->save();

        $year = $expense->year;
        $month = $expense->month;

        // 確定フラグ取得
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // NOKIA経費合計額取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');

        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;

        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();

        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));

    }

    public function user_detail(Request $request){

        // 該当ユーザIDの当月分データを取得
        $year = $request->yeAr;
        $month =$request->monTh;

        if(Auth::User()->isadmin){
            $userid = $request->userId;
        }else{
            $userid = Auth::User()->id;
        }

        // 確定フラグ取得 (non-object caseを考慮)
        $expenseflg = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $eflg = $expenseflg->isconfirm;

        // NOKIA経費合計額取得
        $nokia_total_price = $expenseflg->nokia_total_price;

        // 当月の経費取得
        $expenses = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->orderBy('date', 'asc')->get();

        // 移動費小計
        $subtotal_transportation_fee = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('transportation_fee');
        // ガソリン代小計
        $subtotal_petrol = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('petrol');

        // 駐車代小計
        $subtotal_parking = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('parking');

        // 宿泊費小計
        $subtotal_accommodation = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('accommodation');

        // 出張手当小計
        $subtotal_allowance = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('allowance');

        // その他小計
        $subtotal_other = Expense::where('user_id', $userid)
                                         ->whereYear('date',$year)->whereMonth('date',$month)->sum('other');

        // 合計
        $total_price = $subtotal_transportation_fee + $subtotal_petrol + $subtotal_parking + $subtotal_accommodation + $subtotal_allowance + $subtotal_other;


        // 合計額をexpenses_flgsテーブルに格納
        $expense_flag = Expense_flag::where([ ['user_id', $userid], ['year',$year], ['month',$month] ])->first();
        $expense_flag->total_price = $total_price;
        $expense_flag->save();

        // ユーザ取得
        $users = User::where('id',$userid)->get();



        return view('/expense/expenselist')->with(compact('expenses', $expenses,
                                                 'eflg', $eflg,
                                                 'subtotal_transportation_fee', $subtotal_transportation_fee,
                                                 'subtotal_petrol', $subtotal_petrol,
                                                 'subtotal_parking', $subtotal_parking,
                                                 'subtotal_accommodation', $subtotal_accommodation,
                                                 'subtotal_allowance', $subtotal_allowance,
                                                 'subtotal_other', $subtotal_other,
                                                 'total_price', $total_price,
                                                 'nokia_total_price', $nokia_total_price,
                                                 'year', $year,
                                                 'month', $month,
                                                 'userid', $userid,
                                                 'users', $users));
    }
}
