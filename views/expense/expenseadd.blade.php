@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::User()->isadmin)
                @foreach ($users as $user)
                    <h3>ミナト経費を入力してください：[{{$user->name}}]</h3>
                @endforeach
                <form class="form-horizontal" method="post" action={{url('/expense/expensesstore/'.$user->id)}}>
            @else
                <h3>ミナト経費を入力してください：</h3>
                <form class="form-horizontal" method="post" action={{url('/expense/expensesstore')}}>
            @endif
                <fieldset>

                    {{ csrf_field() }}

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_day">経費発生日</label>
                        <div class="col-md-7 input-group date" data-provide="date">
			    <input id = "start_day" name="start_day" type="text" placeholder="経費発生日" class="form-control input-md" required="">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="transportation_fee">移動費(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="transportation_fee" name="transportation_fee" type="text" class="form-control input-md" value="0" placeholder="移動費">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="departure">From</label>
                        <div class="col-md-2 input-group ">
                            <input id="departure" name="departure" type="text" class="form-control input-md" placeholder="出発場所">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="arrival">To</label>
                        <div class="col-md-2 input-group ">
                            <input id="arrival" name="arrival" type="text" class="form-control input-md" placeholder="到着場所">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="petrol">ガソリン代(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="petrol" name="petrol" type="text" class="form-control input-md" value="0" placeholder="ガソリン代">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="parking">駐車代(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="parking" name="parking" type="text" class="form-control input-md" value="0" placeholder="駐車代">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="accommodation">宿泊費(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="accommodation" name="accommodation" type="text" class="form-control input-md" value="0" placeholder="宿泊費">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="allowance">出張手当(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="allowance" name="allowance" type="text" class="form-control input-md" value="0" placeholder="出張手当">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="other">その他(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="other" name="other" type="text" class="form-control input-md" value="0" placeholder="その他">
                        </div>
                    </div>


                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="description">備考</label>
                        <div class="col-md-2 input-group">
                        <textarea name="description" rows="3" cols="34"></textarea>
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>

                    <!--     ------------------------------------------------------------------------------------------------------ -->



                    <!-- Text input-->
                        <!-- <label class="col-md-4 control-label" for="start_time">作業開始時刻</label> -->
                        <div class="col-md-2 input-group clockpicker1">
                            <input type="hidden" id="start_time" name="start_time" type="text" class="form-control input-md" required="" placeholder="始まる時間">
                        </div>

                    <!-- Text input-->
                        <!-- <label class="col-md-4 control-label" for="finish_time">作業終了時刻</label> -->
                        <div class="col-md-2 input-group clockpicker2">
                            <input type="hidden" id="finish_time" name="finish_time" type="text" placeholder="終了時間" class="form-control input-md" required="">
                        </div>

                    <!-- Select Basic -->
                    <!-- 
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="lunch_time">控除時間</label>
                        <div class="col-md-2 input-group">
                            <select id="lunch_time" name="lunch_time" class="form-control">
                				<option value="1">00:00</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">工数: </label>
                        <span class="col-md-2 input-group" id="duration">00:10</span>
                        <input type="hidden" name="duration" class="durationHid">
                    </div>
                    -->

                    <!-- Select Basic -->
                    <!-- 
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="project">プロジェクトを選択</label>
                        <div class="col-md-4 input-group">
                            <select id="project" name="project" class="form-control">8:00</select>
                        </div>
                    </div>
                    -->

                    <!-- Select Basic -->
                    <!--
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="role">作業内容を選択</label>
                        <div class="col-md-4 input-group">
                            <select id="role" name="role" class="form-control">bbb</select>
                        </div>
                    </div>
                    -->

                    <!-- Select Basic -->
                    <!--
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="workplace">職場を選択</label>
                        <div class="col-md-4 input-group">
                            <select id="workplace" name="workplace" class="form-control">ccc</select>
                        </div>
                    </div>
                    -->

                    <!--
                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="late">備考</label>
                        <div class="col-md-4 input-group">
			<textarea name="late_reason" rows="3" cols="34"></textarea>
			<p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>
                    -->

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

    <script src={{asset('/js/moment.min.js')}}></script>
    <script src={{asset('/js/bootstrap-datepicker.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.ja.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.fr.min.js')}}></script>

    <script type="text/javascript">

    var temp = moment(); //round(new Date(), moment.duration(30, "minutes"));
    var remainder = 30 - temp.minute() % 30;

    // 10:00 -> 10:29 -> 10:00
    // 10:31 -> 10:45 -> 10:30
    // 10:46 -> 10:59 -> 11:00
    if ( temp.minute() > 30 ){
        if (remainder < 15) {
            temp = moment(temp).add(remainder, "minutes");
        } else {
            temp = moment(temp).subtract(30 - remainder, "minutes");
        }
    } else {
        if (remainder < 1) {
            temp = moment(temp).add(remainder, "minutes");
        } else {
            temp = moment(temp).subtract(30 - remainder, "minutes");
        }
    }
    
    var start_time = temp.format("HH:mm");
    var end_time = temp.add(9, "hours").format("HH:mm");
    // console.log(temp.date());
    // console.log(temp.format('DD/MM/YYYY HH:mm:ss'));
	$('.clockpicker1').clockpicker({
            placement: 'bottom',
            align: 'top',
            autoclose: true,
            'default': start_time,
            init: function() {
                $('#start_time').val(start_time);
            },
            afterDone: function() {
                calculateDur();
            }
        });

    $('#start_time').val(start_time);

    $('.clockpicker2').clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true,
        'default': end_time,
        init: function() {
            $('#finish_time').val(end_time);
            calculateDur();
        },
        afterDone: function() {
            calculateDur();
        }
    });

    $('#lunch_time').on('load ready change', function(){
        calculateDur();
    });

    function calculateDur() {
        var tmp = moment();

        var start = $('#start_time').val().split(':');
        var end = $('#finish_time').val().split(":");
        var dur = $('#lunch_time').find(":selected").text().split(":");
        
        var startDate = moment();
        startDate.set('hour', start[0]);
        startDate.set('minute', start[1]);

        var endDate = moment();
        endDate.add(9, "hours");
        endDate.set('hour', end[0]);
        endDate.set('minute', end[1]);

        var durtime = moment();
        durtime.set('hour', dur[0]);
        durtime.set('minute', dur[1]);

        startDate.add(durtime.hours(), 'hours');
        startDate.add(durtime.minutes(), 'minutes');

	if (endDate.diff(startDate, 'hours') < 0) {
		endDate = moment(endDate, "DD-MM-YYYY").add('days', 1);
// momota add start
	} else if (endDate.diff(startDate, 'days') > 0){
		endDate = moment(endDate, "DD-MM-YYYY").subtract('days', 1);
	}
// momota add end

        var hours = endDate.diff(startDate, 'hours');
        var minutes = endDate.diff(startDate, 'minutes') % 60;
        var val = (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;

	$('#duration').html( val );
        $('.durationHid').val( val );

        $('#finish_day').val(endDate.format('YYYY-MM-DD'));
    }


	function dynInput(cbox) {
	    if (cbox.checked) {
		var input = document.createElement('textarea');
		input.rows = 3;
		input.cols = 35;
		input.maxLength = 500;
		input.name = "late_reason";
		input.placeholder = "理由を書いてください。";
		var div = document.createElement("div");
		div.id = cbox.name;
		div.appendChild(input);
		document.getElementById("insertinputs").appendChild(div);
	    } else {
    		document.getElementById(cbox.name).remove();
  	    }
	}

    </script>

    <script>
	$(document).ready(function() {
	    calculateDur();
	    var objToday = new Date(),
            curDay = objToday.getDate() < 10 ? "0" + objToday.getDate() : objToday.getDate(),
            curMonth = (objToday.getMonth() + 1) < 10 ? "0" + (objToday.getMonth() + 1) : objToday.getMonth() + 1,
            curMonth = (objToday.getMonth() + 1),
            curYear = objToday.getFullYear();
            var start_day = curYear + '-' + curMonth + '-' + curDay;


            $('.date').datepicker({
    	        maxViewMode: 2,
    	        todayBtn: "linked",
    	        language: "ja",
    	        orientation: "bottom left",
    	        daysOfWeekHighlighted: "0,6",
    	        autoclose: false,
    	        todayHighlight: true,
    	        toggleActive: true,
                format: "yyyy-mm-dd",
    	        setDate: new Date(),
                multidate: true,
                multidateSeparator: ";",
        　　    init: function() {
                    $('#start_day').val(start_day);
                }
            });

//            $('.date').datepicker('update', new Date());
//	    $('#start_day').val(start_day);
	});
    </script>
@endsection
