@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row panel">  
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="post" action={{url('/userproject/save/'.$userproject->id)}}>
                <fieldset>
                    {{ csrf_field() }}
                    <!-- Form Name -->
                    <legend>作業を修正する:</legend>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_day">作業月日</label>
			<div class="col-md-3 input-group date" data-provide="date">
                            <input id = "start_day" name="start_day" type="text" placeholder="作業日付" class="form-control input-md" required=""  value="{{$userproject->start_day}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <!-- <span class="help-block">作業月日を入力してください</span>   -->
                            <input type="hidden" name="finish_day" id="finish_day" value="{{$userproject->finish_day}}">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_time">作業開始時刻</label>
                        <div class="col-md-2 input-group clockpicker1">
                            <input id="start_time" name="start_time" type="text" class="form-control input-md" required="" placeholder="始まる時間" value="{{$userproject->start_time}}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                            <!-- <span class="help-block">作業開始時刻を入力してください</span>   -->
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="finish_time">作業終了時刻</label>  
                        <div class="col-md-2 input-group clockpicker2">
                            <input id="finish_time" name="finish_time" type="text" placeholder="終了時間" class="form-control input-md" required="" value="{{$userproject->finish_time}}">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="lunch_time">控除時間</label>
                        <div class="col-md-2 input-group">
                            <select id="lunch_time" name="lunch_time" class="form-control">
				<option value="1" @if($userproject->lunch_time == 1) selected="true" @endif >00:00</option>
				<option value="2" @if($userproject->lunch_time == 2) selected="true" @endif >00:30</option>
				<option value="3" @if($userproject->lunch_time == 3) selected="true" @endif >01:00</option>
				<option value="4" @if($userproject->lunch_time == 4) selected="true" @endif >01:30</option>
				<option value="5" @if($userproject->lunch_time == 5) selected="true" @endif >02:00</option>
				<option value="6" @if($userproject->lunch_time == 6) selected="true" @endif >02:30</option>
				<option value="7" @if($userproject->lunch_time == 7) selected="true" @endif >03:00</option>
                                <option value="8" @if($userproject->lunch_time == 8) selected="true" @endif >03:30</option>
                                <option value="9" @if($userproject->lunch_time == 9) selected="true" @endif >04:00</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">工数: </label>
                        <span class="col-md-2 input-group" id="duration">00:10</span>
                        <input type="hidden" name="duration" class="durationHid">
                    </div>
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="project">プロジェクトを選択</label>
                        <div class="col-md-4 input-group">
                            <select id="project" name="project" class="form-control combobox">
                            @foreach ($allprojects as $project)
                                <option value="{{$project->id}}" 
                                @if($project->id == $userproject->project_id) 
                                    selected="true" 
                                @endif
                                >{{ $project->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="role">作業内容を選択</label>
                        <div class="col-md-4 input-group">
                            <select id="role" name="role" class="form-control">
                            @foreach ($allroles as $role)
                                <option value="{{$role->id}}"
                                @if($role->id == $userproject->role_id)
                                    selected="true"
                                    @endif
                                >
                                    {{ $role->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="workplace">職場を選択</label>
                        <div class="col-md-4 input-group">
                            <select id="workplace" name="workplace" class="form-control">
                            @foreach ($allworkplaces as $workplace)
                                <option value="{{$workplace->id}}"
                                @if($workplace->id == $userproject->workplace_id)
                                    selected="true"
                                    @endif
                                >
                                    {{ $workplace->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="late">備考</label>
                        <div class="col-md-4 input-group">
			<textarea name="late_reason" rows="3" cols="34">{{ $userproject->late_reason }}</textarea>
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">
                            <input type="submit" name="save" class="btn btn-success" value="保存する">
                            @if(Auth::User()->isadmin == 0)
                                <a id="skipbtn" href="{{url('taskslist')}}" name="skipbtn" class="btn btn-info">キャンセル</a>
                            @endif
                            @if(Auth::User()->isadmin == 1)
                                <a id="skipbtn" href="{{url('/usertasks/'.$userproject->user_id)}}" name="skipbtn" class="btn btn-info">キャンセル</a>
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


    <script src={{asset('/js/bootstrap-combobox.js')}}></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.combobox').combobox();
        });
    </script>

@endsection
