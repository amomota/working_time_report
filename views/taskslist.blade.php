@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 panel">
			<h3>作業リスト</h3>
			@if(Auth::User()->isadmin == 0)
			<a href="{{url('/home')}}" class="btn btn-primary">新しい作業を入力する</a>
			@endif
			<br>
                        @if(Auth::User()->isadmin == 1)
                        <a href="{{url('/admin')}}" class="btn btn-primary">ユーザーリストに戻る</a>
                        @endif

			<div class="table-responsive">
				<table id="mytable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
					<thead>
						<th class="col-ms-1 text-center">月日</th>
						<th class="col-ms-1 text-center">開始時刻</th>
						<th class="col-ms-1 text-center">終了時刻</th>
                                                <th class="col-ms-1 text-center">控除時間</th>
						<th class="col-ms-1 text-center">工数</th>
						<th class="col-ms-2">プロジェクト</th>
                                                <th class="col-ms-1">作業内容</th>
                                                <th class="col-ms-1">職場</th>
                                                <th class="col-ms-1 text-center">遅刻</th>
						<th class="col-ms-1 text-center">編集</th>
						<th class="col-ms-1 text-center">削除</th>
					</thead>
					<tbody>
					@foreach ($projects as $project)
                        			<tr>
							<td class="col-ms-1 text-center">{{date("Y-m-d",strtotime($project->start_day))}}</td>
							<td class="col-ms-1 text-center">{{$project->start_time}}</td>
							<td class="col-ms-1 text-center">{{$project->finish_time}}</td>
                                                        <td class="col-ms-1 text-center">
								@if($project->lunch_time == 1 || $project->lunch_time == 0) 00:00 @endif
								@if($project->lunch_time == 2) 00:30 @endif 
								@if($project->lunch_time == 3) 01:00 @endif
								@if($project->lunch_time == 4) 01:30 @endif
								@if($project->lunch_time == 5) 02:00 @endif
								@if($project->lunch_time == 6) 02:30 @endif
								@if($project->lunch_time == 7) 03:00 @endif
							</td>
							<td class="col-ms-1 text-center">{{$project->duration}}</td>
							<td class="col-ms-2">{{$project->projname}}</td>
                                                        <td class="col-ms-1">{{$project->rolename}}</td>
                                                        <td class="col-ms-1">{{$project->workplacename}}</td>
							<td class="col-ms-1 text-center">
							@if($project->late == 1)
                        					<p data-placement="top" data-toggle="tooltip" title="{{$project->late_reason}}"><span class="bg-danger btn-xs glyphicon glyphicon-bell"></span></a></p>
							@endif
							</td>
							<td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="編集"><a href="{{url('/userproject/edit/'.$project->id )}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></p></td>
							<td class="col-ms-1 text-center"><p data-placement="top" data-toggle="tooltip" title="削除"><a href="{{url('/userproject/delete/'.$project->id)}}" class="btn btn-danger btn-xs" data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a></p></td>
						</tr>
					@endforeach
					</tbody>
				</table>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<!-- edit modal -->
	<!-- <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					<h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input class="form-control " type="text" placeholder="">
					</div>
					<div class="form-group">

						<input class="form-control " type="text" placeholder="">
					</div>
					<div class="form-group">
						<textarea rows="2" class="form-control" placeholder=""></textarea>


					</div>
				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
				</div>
			</div>
		</div>
	</div> -->

	<!-- delete modal -->
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					<h4 class="modal-title custom_align" id="Heading">Delete this task</h4>
				</div>
				<div class="modal-body">

					<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this task?</div>

				</div>
				<div class="modal-footer ">
					<a href="" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</a>
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
		    
		    $("[data-toggle=tooltip]").tooltip();

		});
	</script>

</div>
@endsection
