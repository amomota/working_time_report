@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="post" action={{url('/export/bulk_export_work_report_start')}}>
                <fieldset>
                    {{ csrf_field() }}
                    <!-- Form Name -->
                    <legend>Excel一括にエクスポートする:</legend>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="export_year">年を選択</label>
                        <div class="col-md-2 input-group">
                            <select id="export_year" name="export_year" class="form-control">
                                <option value="2017" @if($year == 2017) selected="true" @endif >2017年</option>
                                <option value="2018" @if($year == 2018) selected="true" @endif >2018年</option>
                                <option value="2019" @if($year == 2019) selected="true" @endif >2019年</option>
                                <option value="2020" @if($year == 2020) selected="true" @endif >2020年</option>
                            </select>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="export_month">月を選択</label>
                        <div class="col-md-2 input-group">
                            <select id="export_month" name="export_month" class="form-control">
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
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">

                            <input id="ost" type="radio" name="gender" size="35"  checked="checked" value="ost" /><label for="ost">OSTメンバー</label></br>
                            <input id="employee" type="radio" name="gender" size="35" value="employee" /><label for="employee">ミナト社員</label></br>
                            <input id="all" type="radio" name="gender" size="35" value="all" /><label for="all">全員分</label></br></br>

                            <input type="submit" id="regbtn" name="regbtn" class="btn btn-success" value="エクスポート">

                            <a id="skipbtn" href="{{url('admin')}}" name="skipbtn" class="btn btn-info">戻る</a>

                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')

    <script src={{asset('/js/moment.min.js')}}></script>

@endsection

