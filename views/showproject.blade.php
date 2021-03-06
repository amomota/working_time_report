@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">  
        <div class="col-md-8 col-md-offset-2">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_day">作業月日</label>
                        <div class="col-md-3 input-group date" data-provide="date">
                            {{$userproject->start_day}}
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_time">作業開始時刻</label>  
                        <div class="col-md-2 input-group clockpicker1">
                            {{$userproject->start_time}}
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="finish_time">作業終了時刻</label>  
                        <div class="col-md-2 input-group clockpicker2">
                            {{$userproject->finish_time}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="lunch_time">控除時間</label>
                        <div class="col-md-2 input-group">
				            @if($userproject->lunch_time == 1) 00:00 @endif 
				            @if($userproject->lunch_time == 2) 00:30 @endif 
				            @if($userproject->lunch_time == 3) 01:00 @endif 
				            @if($userproject->lunch_time == 4) 01:30 @endif 
				            @if($userproject->lunch_time == 5) 02:00 @endif 
				            @if($userproject->lunch_time == 6) 02:30 @endif 
				            @if($userproject->lunch_time == 7) 03:00 @endif 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">工数: </label>
                        <span class="col-md-2 input-group" id="duration">00:10</span>
                    </div>
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="project">プロジェクトを選択</label>
                        <div class="col-md-4 input-group">
                            {{ $userproject->project_name }}        
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="role">作業内容を選択</label>
                        <div class="col-md-4 input-group">
                            {{ $userproject->role_name }}
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="workplace">職場を選択</label>
                        <div class="col-md-4 input-group">
                            {{ $userproject->workplace_name }}
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: -8px;">
                        <label class="col-md-4 control-label" for="late">遅刻する</label>
                        <div class="col-md-4 input-group">
                        <input disabled id="late" type="checkbox" class="checkbox" name="late_chck" onclick="dynInput(this);" style="float: left; margin-top: 3px;"
                                @if($userproject->late == 1)
					checked
                                @endif
				/>
                                @if($userproject->late == 1)
					<div id="late_chck" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"><textarea rows="3" cols="35" id="late_chck" name="late_reason" placeholder="理由を書いてください。" >{{ $userproject->late_reason }}
					</textarea></div>
                                @endif
                        <p id="insertinputs" style="margin-left: 25px; margin-top: 10px; margin-bottom: -3px;"></p>
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">
                            <a class="btn btn-info" name="edit" href="{{url('/userproject/edit')}}/{{$userproject->id}}">Edit</a>
                            @if(Auth::User()->isadmin)
                            <a id="skipbtn" href="{{url('usertasks')}}/{{$userproject->user_id}}" name="skipbtn" class="btn btn-info">Return to task List</a>
                            @else
                            <a id="skipbtn" href="{{url('taskslist')}}" name="skipbtn" class="btn btn-info">Return to task List</a>
                            @endif
                        </div>
                    </div>

                </fieldset>
        </div>
    </div>
    
</div>
@endsection
