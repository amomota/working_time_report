@extends('layouts.app')

@section('content')

    <form class="form-horizontal" method="post" action={{url('/expense/expense_status/redraw')}}>

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
 
    <table>
        <tr valign="top">
            <td>
                <table border="1">
                    <caption class="text-center">社員</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->isregularemployee == 1)
                                        <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>

                                        @foreach($eflgs as $eflg)
                                            @if($user->id == $eflg->user_id)
                                                @if($eflg->isconfirm == 0)
                                                    <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                @else
                                                    <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                @endif

                                                <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

            <td>
                <table border="1">
                    <caption class="text-center">ノキア：ミナト経由</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->via_id == 1)
                                        @if($user->isregularemployee == 0)
                                            @if($user->engaged_in == 0)
                                                <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>
                                                @foreach($eflgs as $eflg)
                                                    @if($user->id == $eflg->user_id)
                                                        @if($eflg->isconfirm == 0)
                                                            <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                        @else
                                                            <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                        @endif

                                                        <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                        <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

            <td>
                <table border="1">
                    <caption class="text-center">ノキア：OST経由</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->via_id == 2)
                                        @if($user->isregularemployee == 0)
                                            @if($user->engaged_in == 0)
                                                <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>

                                                @foreach($eflgs as $eflg)
                                                    @if($user->id == $eflg->user_id)
                                                        @if($eflg->isconfirm == 0)
                                                            <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                        @else
                                                            <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                        @endif

                                                        <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                        <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

            <td>
                <table border="1">
                    <caption class="text-center">ノキア：NESIC経由</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->via_id == 3)
                                        @if($user->isregularemployee == 0)
                                            @if($user->engaged_in == 0)
                                                <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>

                                                @foreach($eflgs as $eflg)
                                                    @if($user->id == $eflg->user_id)
                                                        @if($eflg->isconfirm == 0)
                                                            <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                        @else
                                                            <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                        @endif

                                                        <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                        <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

            <td>
                <table border="1">
                    <caption class="text-center">ノキア：インセクト経由</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->via_id == 4)
                                        @if($user->isregularemployee == 0)
                                            @if($user->engaged_in == 0)
                                                <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>

                                                @foreach($eflgs as $eflg)
                                                    @if($user->id == $eflg->user_id)
                                                        @if($eflg->isconfirm == 0)
                                                            <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                        @else
                                                            <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                        @endif

                                                        <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                        <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

            <td>
                <table border="1">
                    <caption class="text-center">ノキア以外の方</caption>
                    <th class="col-ms-3 text-center">名前</th>
                    <th class="ol-ms-3 text-center">{{$month}}月分</th>
                    <th class="ol-ms-3 text-center">ミナト</th>
                    <th class="ol-ms-3 text-center">NOKIA</th>

                    @foreach($users as $user)
                        <tr>
                            @if($user->isadmin == 0)
                                @if($user->isactive == 1)
                                    @if($user->isregularemployee == 0)
                                        @if($user->engaged_in == 1)
                                            <td class="col-ms-1 text-center"><a href="{{url('/expense/expenses_user_detail/'.$user->id.'/'.$year.'/'.$month)}}">{{$user->name}}</a></td>

                                            @foreach($eflgs as $eflg)
                                                @if($user->id == $eflg->user_id)
                                                    @if($eflg->isconfirm == 0)
                                                        <td class="col-ms-1 text-center" bgcolor="red" ><font color="white">未確定</font></td>
                                                    @else
                                                        <td class="col-ms-1 text-center" bgcolor="blue" ><font color="white">確定済み</font></td>
                                                    @endif

                                                    <td class="col-ms-1 text-center">{{$eflg->total_price}}</td>
                                                    <td class="col-ms-1 text-center">{{$eflg->nokia_total_price}}</td>

                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>

        </tr>
    </table>
    <br>
    <br>
@endsection
