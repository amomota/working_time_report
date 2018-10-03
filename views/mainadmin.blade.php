@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{url('/totalwork')}}" class="btn btn-primary">総労働時間確認</a>
    <a href="{{url('/user/signup')}}" class="btn btn-primary">ユーザ登録</a>
    <a href="{{url('/expense/expense_status')}}" class="btn btn-primary">勤務表作成状況</a>
    <a href="{{url('/export/bulk_export_work_report')}}" class="btn btn-primary">一括エクスポート</a>
    <br><br>

    <table>
      <tr valign="top">

        <td>
          <table border="1">
            <caption class="text-center">所属会社</caption>
            <th class="col-ms-3 text-center">会社名</th>
            <th class="ol-ms-3 text-center">人数</th>

            @foreach($affiliations as $affiliation)
            <tr>
                <td class="col-ms-1 text-center">{{$affiliation->name}}</td>
                <td class="col-ms-1 text-center">{{$affiliation->total}}</td>
            </tr>
            @endforeach

          </table>
        </td>

        <td>
          <table border="1">
            <caption class="text-center">経由</caption>
            <th class="col-ms-3 text-center">会社名</th>
            <th class="ol-ms-3 text-center">人数</th>

            @foreach($vias as $via)
            <tr>
                <td class="col-ms-1 text-center">{{$via->name}}</td>
                <td class="col-ms-1 text-center">{{$via->total}}</td>
            </tr>
            @endforeach

          </table>
        </td>

        <td>
          <table border="1">
            <caption class="text-center">社員</caption>
            <th class="col-ms-3 text-center">正社員</th>
            <th class="ol-ms-3 text-center">人数</th>

            <tr>
                <td class="col-ms-1 text-center">ミナト</td>
                <td class="col-ms-1 text-center">{{$isregularemployee_count}}</td>
            </tr>

          </table>
        </td>

      </tr>
    </table>

    <div class="row">
            <div class="panel-heading">
                <h3>ユーザーを選択</h3>
            </div>

            <div class="table-responsive">
                <table id="admintable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
                    <thead>
                        <th class="col-ms-3 text-center">名前</th>
                        <th class="col-ms-3 text-center">経由会社</th>
                        <th class="col-ms-3 text-center">所属会社</th>
                        <th class="col-ms-3 text-center">所属チーム</th>
                        <th class="col-ms-3 text-center">入場日</th>
                        <th class="col-ms-3 text-center">退場日</th>
			<th class="col-ms-3 text-center">プロフィール</th>
                        <th class="col-ms-3 text-center">編集</th>
                        <!-- コメントアウト
                        <th class="col-ms-3 text-center">削除</th>
                        -->
                    </thead>
 
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                @if($user->isadmin == 0)
                                    @if($user->isactive == 1)

                                        <td class="col-ms-1 text-center"><a href="{{url('/usertasks/'.$user->id)}}" >{{$user->name}}</a></td>

                                        @foreach($vias as $via)
                                            @if( $user->via_id == $via->id)
                                                <td class="col-ms-1 text-center">{{$via->name}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($affiliations as $affiliation)
                                            @if( $user->affiliation_id == $affiliation->id)
                                                <td class="col-ms-1 text-center">{{$affiliation->name}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($teams as $team)
                                            @if( $user->team_id == $team->id)
					        <td class="col-ms-1 text-center">{{$team->name}}</td>
                                            @endif
                                        @endforeach

                                        <td class="col-ms-1 text-center">{{$user->nokia_in}}</td>
                                        <td class="col-ms-1 text-center">{{$user->nokia_out}}</td>

					<td class="col-ms-1 text-center"><a href="{{url('/user/userprofile/'.$user->id)}}" >詳細表示</a></td>
                                        <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="編集"><a href="{{url('/user/userprofile/edit/'.$user->id )}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></p></td>

                                        <!-- コメントアウト
                                        <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="削除"><a href="{{url('/user/userprofile/delete/'.$user->id )}}" class="btn btn-danger btn-xs" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>
                                        -->

			            @endif
			        @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="panel-heading">
                    <h3>過去の在籍者</h3>
                </div>
                <table id="admintable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
                    <tbody>
                        <th class="col-ms-1 text-center">名前</th>
                        <th class="col-ms-3 text-center">経由会社</th>
                        <th class="col-ms-3 text-center">所属会社</th>
                        <th class="col-ms-3 text-center">所属チーム</th>
                        <th class="col-ms-3 text-center">入場日</th>
                        <th class="col-ms-3 text-center">退場日</th>
			<th class="col-ms-3 text-center">プロフィール</th>
                        <th class="col-ms-3 text-center">編集</th>
                        <!-- コメントアウト
                        <th class="col-ms-3 text-center">削除</th>
                        -->
                       @foreach($users as $user)
                            <tr>
                                @if($user->isadmin == 0)
                                    @if($user->isactive == 0)
                                        <td class="col-ms-1 text-center"><a href="{{url('/usertasks/'.$user->id)}}" >{{$user->name}}</a></td>

                                        @foreach($vias as $via)
                                            @if( $user->via_id == $via->id)
                                                <td class="col-ms-1 text-center">{{$via->name}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($affiliations as $affiliation)
                                            @if( $user->affiliation_id == $affiliation->id)
                                                <td class="col-ms-1 text-center">{{$affiliation->name}}</td>
                                            @endif
                                        @endforeach

                                        @foreach($teams as $team)
                                            @if( $user->team_id == $team->id)
                                                <td class="col-ms-1 text-center">{{$team->name}}</td>
                                            @endif
                                        @endforeach

                                        <td class="col-ms-1 text-center">{{$user->nokia_in}}</td>
                                        <td class="col-ms-1 text-center">{{$user->nokia_out}}</td>

					<td class="col-ms-1 text-center"><a href="{{url('/user/userprofile/'.$user->id)}}" >詳細表示</a></td>
                                        <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="編集"><a href="{{url('/user/userprofile/edit/'.$user->id )}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></p></td>

                                        <!-- コメントアウト
                                        <td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="削除"><a href="{{url('/userprofile/delete/'.$user->id )}}" class="btn btn-danger btn-xs" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>
                                        -->

                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
</div>

@endsection
