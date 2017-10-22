@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-6 col-md-offset-3 panel panel-default">
			<div class="panel-heading"><h3>ユーザーを選択</h3></div>
			<div class="panel-body">
				<div class="list-group">
				@foreach($users as $user)
				 @if($user->isadmin == 0)
				  <a href="{{url('/usertasks/'.$user->id)}}" class="list-group-item">{{$user->name}}</a>
				 @endif
				@endforeach
				</div>
			</div>
		</div>
	</div>

</div>
@endsection
