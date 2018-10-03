@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 panel">

            @if(Auth::User()->isadmin == 0)
                <h3>経費精算リスト</h3>
                <a href="{{url('/taskslist')}}" class="btn btn-primary">作業リストに戻る</a>
                <a href="{{url('/expense/expensesadd')}}" class="btn btn-primary">ミナト経費を入力する</a>
                <a href="{{url('/expense/nokia_expensesadd')}}" class="btn btn-primary">Nokia経費を入力する</a>
                <a href="{{url('/export/exportexcel')}}" class="btn btn-primary" style="float: right;">Excel エクスポート</a>
            @endif

            @if(Auth::User()->isadmin == 1)
                @foreach ($users as $user)
                    <h3>経費精算リスト：[{{$user->name}}]</h3>
                @endforeach
                <a href="{{url('/usertasks/'.$userid)}}" class="btn btn-primary">作業リストに戻る</a>
                <a href="{{url('/expense/expensesadd/'.$user->id)}}" class="btn btn-primary">ミナト経費を入力する</a>
                <a href="{{url('/expense/nokia_expensesadd/'.$user->id)}}" class="btn btn-primary">Nokia経費を入力する</a>
                <a href="{{url('/export/exportexcel/'.$user->id)}}" class="btn btn-primary" style="float: right;">Excel エクスポート</a>
            @endif

            <hr>
            @if(Auth::User()->isadmin)
                <form class="form-horizontal" method="post" action={{url('/expense/expenses_redraw/'.$userid)}}>
            @else
                <form class="form-horizontal" method="post" action={{url('/expense/expenses_redraw')}}>
            @endif

                <fieldset>
                    {{ csrf_field() }}
                    <table>
                        <!-- Select Basic -->
                        <th><label for="expenses_year">年月を選択</label></th>

                        <th>
                            <select id="expenses_year" name="expenses_year" class="form-control">
                                <option value="2017" @if($year == 2017) selected="true" @endif >2017年</option>
                                <option value="2018" @if($year == 2018) selected="true" @endif >2018年</option>
                                <option value="2019" @if($year == 2019) selected="true" @endif >2019年</option>
                            </select>
                        </th>

                        <!-- Select Basic -->
                        <th>
                            <select id="expenses_month" name="expenses_month" class="form-control">
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

                        <!-- Button (Double) -->
                        <th>
                            <label for="viewbtn"></label>
                            <input type="submit" id="viewbtn" name="viewbtn"  value="表示">
                        </th>
                    </table>
                </fieldset>
            </form>

            <br>
            <h4 align="left"><u>ミナト経費合計：￥{{$total_price}}　　　　Nokia経費合計：￥{{$nokia_total_price}}</u></h4>
            <h3 align="left">ミナト経費</h3>

            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
                    <thead>
                        <th class="col-ms-1 text-center">日付</th>
                        <th class="col-ms-1 text-right">移動費</th>
                        <th class="col-ms-1 text-center">From</th>
                        <th class="col-ms-1 text-center">To</th>
                        <th class="col-ms-1 text-right">ガソリン代</th>
                        <th class="col-ms-1 text-right">駐車代</th>
                        <th class="col-ms-1 text-right">宿泊費</th>
                        <th class="col-ms-1 text-right">出張手当</th>
                        <th class="col-ms-1 text-right">その他</th>
                        <th class="col-ms-2 text-center">備考</th>
                        <th class="col-ms-1 text-center">編集</th>
                        <th class="col-ms-1 text-center">削除</th>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td class="col-ms-1 text-center">{{date("Y-m-d",strtotime($expense->date))}}</td>
                                <td class="col-ms-1 text-right">{{$expense->transportation_fee}}</td>
                                <td class="col-ms-1 text-center">{{$expense->departure}}</td>
                                <td class="col-ms-1 text-center">{{$expense->arrival}}</td>
                                <td class="col-ms-1 text-right">{{$expense->petrol}}</td>
                                <td class="col-ms-1 text-right">{{$expense->parking}}</td>
                                <td class="col-ms-1 text-right">{{$expense->accommodation}}</td>
                                <td class="col-ms-1 text-right">{{$expense->allowance}}</td>
                                <td class="col-ms-1 text-right">{{$expense->other}}</td>
                                <td class="col-ms-2 text-center">{{$expense->description}}</td>
                                <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="編集"><a href="{{url('/expense/edit/'.$expense->id )}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></p></td>
                                <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="削除"><a href="{{url('/expense/delete/'.$expense->id.'/'.$expense->date)}}" class="btn btn-danger btn-xs" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <th class="col-ms-1 text-center">小計</th>
                        <th class="col-ms-1 text-right">{{$subtotal_transportation_fee}}</th>
                        <th class="col-ms-1 text-center"></th>
                        <th class="col-ms-1 text-center"></th>
                        <th class="col-ms-1 text-right">{{$subtotal_petrol}}</th>
                        <th class="col-ms-1 text-right">{{$subtotal_parking}}</th>
                        <th class="col-ms-1 text-right">{{$subtotal_accommodation}}</th>
                        <th class="col-ms-1 text-right">{{$subtotal_allowance}}</th>
                        <th class="col-ms-1 text-right">{{$subtotal_other}}</th>
                        <th class="col-ms-2 text-center">合計 ￥{{$total_price}}</th>
                        <th class="col-ms-1 text-center"></th>
                        <th class="col-ms-1 text-center"></th>
                    </thead>
                </table>
                <div class="clearfix"></div>
            </div>

            <h3 align="left">Nokia経費</h3>
              <table id="nokia_expenses_table" class="table-bordred table-striped table-condensed" style="margin-top:7px">
                <thead>
                  <th class="col-ms-1 text-center">Nokia経費合計</th>
                  <th class="col-ms-1 text-center">編集</th>
                </thead>
                <tbody>
              <th class="col-ms-1 text-center">￥{{$nokia_total_price}}</th>
              <th class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="編集"><a href="{{url('/nokia_expense/edit/'.$userid.'/'.$year.'/'.$month )}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></p></th>
                </tbody>
            </table>

            <br>
            <table>
                @if($eflg == 0)
                    @if(Auth::User()->isadmin)
                        <th><a href="{{url('/expense/confirm/'.$user->id.'/'.$year.'/'.$month)}}" class="btn btn-info" data-title="confirm">{{$year}}年{{$month}}月の入力を確定する</a></th>
                    @else
                        <th><a href="{{url('/expense/confirm/'.$year.'/'.$month)}}" class="btn btn-info" data-title="confirm">{{$year}}年{{$month}}月の入力を確定する</a></th>
                    @endif
                @else
                    @if(Auth::User()->isadmin)
                        <th><a href="{{url('/expense/confirm/'.$user->id.'/'.$year.'/'.$month)}}" class="btn btn-warning" data-title="confirm">{{$year}}年{{$month}}月の確定を解除する</a></th>
                    @else
                        <th><a href="{{url('/expense/confirm/'.$year.'/'.$month)}}" class="btn btn-warning" data-title="confirm">{{$year}}年{{$month}}月の確定を解除する</a></th>
                    @endif
                @endif

                @if($eflg == 0)
                    <th bgcolor="red"><font color="white">未確定</font></th>
                @else
                    <th bgcolor="blue"><font color="white">確定済</font></th>
                @endif

            </table>

            <br><br>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("[data-toggle=tooltip]").tooltip();
        });
    </script>
</div>
@endsection
