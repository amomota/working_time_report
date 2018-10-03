@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            @if (Auth::User()->isadmin) 
                <form class="form-horizontal" method="post" action={{url('/batchsave/'.$userid)}}>
            @else
                <form class="form-horizontal" method="post" action={{url('/batchsave/')}}>
            @endif
                <fieldset>
                    {{ csrf_field() }}
                    <!-- Form Name -->
                    <legend>休暇する日程と理由を入力してください:</legend>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="day_list">休暇月日</label>
                        <div class="col-md-8 input-group date" data-provide="date">
                            <input id = "day_list" name="day_list" type="text" placeholder="休暇日を選択" class="form-control input-md" required="">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            <!-- <span class="help-block">休暇月日を入力してください</span>   -->
                        </div>
                    </div>

                    <div class="form-group"  style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="nightshift_chck">夜勤明け</label>
                        <div class="col-md-4 input-group">
                        <input id="nightshift_chck" type="checkbox" class="checkbox" name="nightshift_chck" onclick="dynInput(this);" style="float: left; margin-top: 3px;"/>
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="leave_reason">休暇理由</label>
                        <div class="col-md-8 input-group ">
                        <textarea id="leave_reason" name="leave_reason" rows="4" cols="70" class="form-control input-md" required=""></textarea>
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">
                            <input type="submit" id="regbtn" name="regbtn" class="btn btn-success" value="保存する">
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
    <script src={{asset('/js/bootstrap-datepicker.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.ja.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.fr.min.js')}}></script>

    <script type="text/javascript">

    $('.date').datepicker({
        maxViewMode: 2,
        todayBtn: "linked",
        language: "ja",
        daysOfWeekHighlighted: "0,6",
        autoclose: false,
        todayHighlight: true,
        toggleActive: true,
        setDate: new Date(),
        format: "yyyy-mm-dd",
        multidate: true,
        multidateSeparator: ";",
        //$('.date').datepicker('update', new Date());
    });

    </script>

    <script type="text/javascript">
 
    function dynInput(cbox) {
        var e = document.getElementById ('leave_reason');
        if (cbox.checked) {
           e.value = "夜勤明け";
        } else {
           e.value = "";
        }
    }

    </script>

@endsection
