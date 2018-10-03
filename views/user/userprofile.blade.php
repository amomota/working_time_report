@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 panel">
            <div class="panel-heading">
                <h3>ユーザープロファイル</h3>
            </div>
            <div class="table-responsive">
                <table id="admintable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
		    <tbody>
		    @foreach ($users as $users)
			<tr>
                        <th class="col-ms-3 text-center">ID</th>
			<td class="col-ms-1 text-center">{{$users->id}}</td>                       
			</tr>

			<tr>
			<th class="col-ms-3 text-center">フルネーム</th>
			<td class="col-ms-3 text-center">{{$users->name}}</td>
			</tr>

			<tr>
			<th class="col-ms-3 text-center">ふりがな</th>
                        <td class="col-ms-3 text-center">{{$users->aiueo_rder}}</td>
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">ユーザーID</th>
                        <td class="col-ms-3 text-center">{{$users->username}}</td>
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">Email</th>
                        <td class="col-ms-3 text-center">{{$users->email}}</td>
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">IsActive</th>
                        <td class="col-ms-3 text-center">{{$users->isactive}}</td>
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">IsAdmin</th>
                        <td class="col-ms-3 text-center">{{$users->isadmin}}</td>
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">Last_Login</th>
                        <td class="col-ms-3 text-center">{{$users->last_login}}</td>
			</tr>

			<tr>
			<th class="col-ms-3 text-center">経由会社</th>
	                    @foreach($vias as $via)
                                @if( $users->via_id == $via->id)
                                    <td class="col-ms-1 text-center">{{$via->name}}</td>
                                @endif
                            @endforeach
			</tr>

			<tr>
			<th class="col-ms-3 text-center">所属会社</th>
                            @foreach($affiliations as $affiliation)
                                @if( $users->affiliation_id == $affiliation->id)
                                    <td class="col-ms-1 text-center">{{$affiliation->name}}</td>
                                @endif
                            @endforeach
			</tr>
			
			<tr>
			<th class="col-ms-3 text-center">Isregularemployee</th>
                        <td class="col-ms-3 text-center">{{$users->isregularemployee}}</td>

			<tr>
			<th class="col-ms-3 text-center">Team</th>
                            @foreach($teams as $team)
                                @if( $users->team_id == $team->id)
                                    <td class="col-ms-1 text-center">{{$team->name}}</td>
                                @endif
                            @endforeach
			</tr>

                        <tr>
                        <th class="col-ms-3 text-center">Nokia入場日</th>
                        <td class="col-ms-3 text-center">{{$users->nokia_in}}</td>
                        </th>
                        </tr>

                        <tr>
                        <th class="col-ms-3 text-center">Nokia退場日</th>
                        <td class="col-ms-3 text-center">{{$users->nokia_out}}</td>
                        </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
