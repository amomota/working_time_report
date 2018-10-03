@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::User()->isadmin)
                <form class="form-horizontal" method="post" action={{url('/export/exportexcel_confirm/'.$userid)}}>
            @else
                <form class="form-horizontal" method="post" action={{url('/export/exportexcel_confirm')}}>
            @endif
                <fieldset>
                    {{ csrf_field() }}
                    <!-- Form Name -->
                    <legend>Excelにエクスポートする:</legend>

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
                                <option value="1">1月</option>
                                <option value="2">2月</option>
                                <option value="3">3月</option>
                                <option value="4">4月</option>
                                <option value="5">5月</option>
                                <option value="6">6月</option>
                                <option value="7">7月</option>
                                <option value="8">8月</option>
                                <option value="9">9月</option>
                                <option value="10">10月</option>
                                <option value="11">11月</option>
                                <option value="12">12月</option>
                            </select>
                        </div>
                    </div>



                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
        	        <div class="col-md-8">

			    <input id="ost" type="radio" name="gender" size="35"  checked="checked" value="ost" /><label for="ost">OST</label>	
			    <input id="minato" type="radio" name="gender" size="35" value="minato" /><label for="minato">MINATO</label>
			    </br>

			    <input type="submit" id="regbtn" name="regbtn" class="btn btn-success" value="エクスポート">

                            @if (Auth::User()->isadmin)
                                <a id="skipbtn" href="{{url('usertasks/'.$userid)}}" name="skipbtn" class="btn btn-info">戻る</a>
                            @else
                                <a id="skipbtn" href="{{url('taskslist')}}" name="skipbtn" class="btn btn-info">戻る</a>
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

    <script src={{asset('/js/moment.min.js')}}></script>

@endsection

