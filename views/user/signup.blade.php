@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row panel">
        <div class="col-md-8 col-md-offset-2">
            <h3>各項目を入力してください</h3>

                <form class="form-horizontal" method="post" action={{url('/user/signupstore')}}>

                <fieldset>

                    {{ csrf_field() }}

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="name">フルネーム</label>
                        <div class="col-md-4 input-group ">
                            <input id="name" name="name" type="text" class="form-control input-md" placeholder="例)菊池 修吏">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="aiueo_rder">ふりがな</label>
                        <div class="col-md-4 input-group ">
                            <input id="aiueo_rder" name="aiueo_rder" type="text" class="form-control input-md" placeholder="例)きくちしゅうじ">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="username">ユーザーネーム</label>
                        <div class="col-md-4 input-group ">
                            <input id="username" name="username" type="text" class="form-control input-md" placeholder="入力されていません">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="email">Email</label>
                        <div class="col-md-4 input-group ">
                            <input id="email" name="email" type="text" class="form-control input-md" placeholder="指定されたEmailを入力">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="password">Password</label>
                        <div class="col-md-4 input-group ">
                            <input id="password" name="password" type="text" class="form-control input-md" placeholder="指定されたPasswordを入力">
                        </div>
                    </div>


                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="via_id">経由会社</label>
                        <div class="col-md-4 input-group ">
                            <select id="via_id" name="via_id" class="form-control">
                            @foreach($vias as $via)
                                <option value="{{$via->id}}"
                                    @if($via->id == $users->via_id)
                                        selected="true"
                                        @endif
                                >
                                        {{ $via->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="affiliation_id">所属会社</label>
                        <div class="col-md-4 input-group ">
                            <select id="affiliation_id" name="affiliation_id" class="form-control">
                            @foreach($affiliations as $affiliation)
                                <option value="{{$affiliation->id}}"
                                    @if($affiliation->id == $users->affiliation_id)
                                        selected="true"
                                        @endif
                                >
                                        {{ $affiliation->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="team_id">TEAM</label>
                        <div class="col-md-4 input-group ">
                            <select id="team_id" name="team_id" class="form-control">
                            @foreach($teams as $team)
                                <option value="{{$team->id}}"
                                    @if($team->id == $users->team_id)
                                        selected="true"
                                        @endif
                                >
                                        {{ $team->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-5 control-label" for="nokia_in">Nokia入場日</label>
                        <div class="col-md-4 input-group date" data-provide="date">
                            <input id="nokia_in" name="nokia_in" type="text" class="form-control input-md" placeholder="入場日">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Button (Double) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="regbtn"></label>
                        <div class="col-md-8">
                            <input type="submit"id="regbtn" name="regbtn" class="btn btn-success" value="保存する">
                         
                            <a id="skipbtn"  href="{{url('admin')}}" name="skipbtn"  class="btn btn-info">戻る</a>
                        </div>
                    </div>

                </fieldset>
           </from>
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
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        setDate: new Date(),
        format: "yyyy-mm-dd",
        //$('.date').datepicker('update', new Date());
    });

    </script>

@endsection
