@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">  
        <div class="col-md-8 col-md-offset-2">

            @if(Auth::User()->isadmin)
                @foreach ($users as $user)
                    <h3>ミナト経費を修正する：[{{$user->name}}]</h3>
                @endforeach
            @else
                <h3>ミナト経費を修正する：</h3>
            @endif

            <form class="form-horizontal" method="post" action={{url('/expense/save/'.$expense->id)}}>
                <fieldset>

                    {{ csrf_field() }}

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_day">経費発生日</label>
                        <div class="col-md-3 input-group date" data-provide="date">
                            <input id = "start_day" name="start_day" type="text" class="form-control input-md" required=""  value="{{$expense->date}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="transportation_fee">移動費(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="transportation_fee" name="transportation_fee" type="text" class="form-control input-md" value="{{$expense->transportation_fee}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="departure">From</label>
                        <div class="col-md-2 input-group ">
                            <input id="departure" name="departure" type="text" class="form-control input-md" value="{{$expense->departure}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="arrival">To</label>
                        <div class="col-md-2 input-group ">
                            <input id="arrival" name="arrival" type="text" class="form-control input-md" value="{{$expense->arrival}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="petrol">ガソリン代(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="petrol" name="petrol" type="text" class="form-control input-md" value="{{$expense->petrol}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="parking">駐車代(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="parking" name="parking" type="text" class="form-control input-md" value="{{$expense->parking}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="accommodation">宿泊費(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="accommodation" name="accommodation" type="text" class="form-control input-md" value="{{$expense->accommodation}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="allowance">出張手当(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="allowance" name="allowance" type="text" class="form-control input-md" value="{{$expense->allowance}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="other">その他(￥)</label>
                        <div class="col-md-2 input-group ">
                            <input id="other" name="other" type="text" class="form-control input-md" value="{{$expense->other}}">
                        </div>
                    </div>


                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="description">備考</label>
                        <div class="col-md-4 input-group">
                        <textarea name="description" rows="3" cols="34">{{ $expense->description }}</textarea>
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>
                    <!--     ------------------------------------------------------------------------------------------------------ -->


                    <!-- Text input-->
                    <div class="form-group">
                        <!-- <label class="col-md-4 control-label" for="start_time">作業開始時刻</label> -->
                        <div class="col-md-2 input-group clockpicker1">
                            <input type="hidden" id="start_time" name="start_time" type="text" class="form-control input-md" required="" placeholder="始まる時間">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <!-- <label class="col-md-4 control-label" for="finish_time">作業終了時刻</label> --> 
                        <div class="col-md-2 input-group clockpicker2">
                            <input type="hidden" id="finish_time" name="finish_time" type="text" placeholder="終了時間" class="form-control input-md" required="">
                        </div>
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
                            <input type="submit" name="save" class="btn btn-success" value="保存する">
                            @if(Auth::User()->isadmin)
                                <a id="skipbtn" href="{{url('/expense/expenses_processing/'.$expense->user_id)}}" name="skipbtn" class="btn btn-info">戻る</a>
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
    
    <script type="text/javascript">
        $('.clockpicker1').clockpicker({
            placement: 'bottom',
            align: 'top',
            autoclose: true,
            afterDone: function() {
                calculateDur();
            }
        });

        $('.clockpicker2').clockpicker({
            placement: 'bottom',
            align: 'top',
            autoclose: true,
            init: function() { 
                // $('#finish_time').val(end_time);
                calculateDur();
            },
            afterDone: function() {
                calculateDur();
            }
        });

        function calculateDur() {
            var start = $('#start_time').val().split(':');
            var end = $('#finish_time').val().split(":");
// momota add start
            var dur = $('#lunch_time').find(":selected").text().split(":");
// momota add end
            var startDate = new Date(0, 0, 0, start[0], start[1], 0);
            var endDate = new Date(0, 0, 0, end[0], end[1], 0);
            var diff = endDate.getTime() - startDate.getTime();
            var hours = Math.floor(diff / 1000 / 60 / 60);
            diff -= hours * 1000 * 60 * 60;
            var minutes = Math.floor(diff / 1000 / 60);

            // If using time pickers with 24 hours format, add the below line get exact hours
            if (hours < 0)
                hours = hours + 24;

//            prompt("startDate",startDate);
//            prompt("endDate",endDate);
//            endDate.setDate(endDate.getDate()+1);
//            prompt("startDate",startDate);
//            prompt("endDate",endDate);
// momota mod start
            var val = ((hours - dur[0]) <= 9 ? "0" : "") + (hours - dur[0]) + ":" + (minutes <= 9 ? "0" : "") + minutes;
// momota mod end
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

    <script src={{asset('/js/bootstrap-datepicker.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.ja.min.js')}}></script>
    <script src={{asset('/js/locales/bootstrap-datepicker.fr.min.js')}}></script>

    <script>
        $(document).ready(function() {
            var objToday = new Date(),
            curDay = objToday.getDate() < 10 ? "0" + objToday.getDate() : objToday.getDate(),
            curMonth = (objToday.getMonth() + 1) < 10 ? "0" + (objToday.getMonth() + 1) : objToday.getMonth() + 1,
            curYear = objToday.getFullYear();
            var start_day = curYear + '/' + curMonth + '/' + curDay;

            $('.date').datepicker({
                maxViewMode: 2,
                todayBtn: "linked",
                language: "ja",
                orientation: "bottom left",
                daysOfWeekHighlighted: "0,6",
                autoclose: true,
                todayHighlight: true,
                toggleActive: true,
                format: "yyyy-mm-dd",
                setDate: new Date(),
        　　    init: function() {
                    $('#start_day').val(start_day);
                }
            });
//            $('#start_day').val(start_day);
        });
    </script>

@endsection
