@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::User()->isadmin)
                @foreach ($users as $user)
                    <h3>Nokia経費を入力してください：[{{$user->name}}]</h3>
                @endforeach
                <form class="form-horizontal" method="post" action={{url('/expense/nokia_expensesstore/'.$user->id)}}>
            @else
                <h3>Nokia経費を入力してください：</h3>
                <form class="form-horizontal" method="post" action={{url('/expense/nokia_expensesstore')}}>
            @endif
                <fieldset>

                    {{ csrf_field() }}

                    <!-- Text input-->

                    <table align=center>
                        <div class="form-group">
                            <th>
                                <th><label for="expenses_year">年月を選択</label></th>
                            </th>
                        
                            <div class="col-md-2 input-group month" data-provide="year">
                                <th>
                                    <select id="expenses_year" name="nokia_expenses_year" class="form-control">
                                        <option value="2017" @if($year == 2017) selected="true" @endif >2017年</option>
                                        <option value="2018" @if($year == 2018) selected="true" @endif >2018年</option>
                                        <option value="2019" @if($year == 2019) selected="true" @endif >2019年</option>
                                    </select>
                                </th>
                            </div>

                            <div class="col-md-2 input-group month" data-provide="month">
                                <th>
                                    <select id="expenses_month" name="nokia_expenses_month" class="form-control">
                                        <option value="1"  @if($month == 1)  selected="true" @endif >1月</option>
                                        <option value="2"  @if($month == 2)  selected="true" @endif >2月</option>
                                        <option value="3"  @if($month == 3)  selected="true" @endif >3月</option>
                                        <option value="4"  @if($month == 4)  selected="true" @endif >4月</option>
                                        <option value="5"  @if($month == 5)  selected="true" @endif >5月</option>
                                        <option value="6"  @if($month == 6)  selected="true" @endif >6月</option>
                                        <option value="7"  @if($month == 7)  selected="true" @endif >7月</option>
                                        <option value="8"  @if($month == 8)  selected="true" @endif >8月</option>
                                        <option value="9"  @if($month == 9)  selected="true" @endif >9月</option>
                                        <option value="10" @if($month == 10) selected="true" @endif >10月</option>
                                        <option value="11" @if($month == 11) selected="true" @endif >11月</option>
                                        <option value="12" @if($month == 12) selected="true" @endif >12月</option>
                                    </select>
                                </th>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <th>
                                <label class="col-md-6 control-label" for="nokia_total_price">Nokia経費合計額(￥)</label>
                                <div class="col-md-5 input-group ">
                                    <input id="nokia_total_price" name="nokia_total_price" type="text" class="form-control input-md" value="0" placeholder="合計">
                                </div>
                            </th>
                        </div>
                    </table>

                    <br>


                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">
                            <input type="submit" id="regbtn" name="regbtn" class="btn btn-success" value="保存する">
                            @if(Auth::User()->isadmin)
                                <a id="skipbtn" href="{{url('/expense/expenses_processing/'.$user->id)}}" name="skipbtn" class="btn btn-info">戻る</a>
                            @else
                                <a id="skipbtn" href="{{url('/expense/expenses_processing')}}" name="skipbtn" class="btn btn-info">戻る</a>
                            @endif
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
