@extends('masterlayout')

@section('title', 'Blacklist')

@section('page-script')
<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
<script>
	function filter(query){
		if (query != ""){
			$.ajax({
				url: '{{ URL::to( "TheGreatWall/blacklist/filter" )}}',
				type: 'GET',
				data: 'query='+query,
				success : function(response){
					console.log(response);
				}
			}, "json");
		}
	};
</script>
@stop

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<form>
		<input type="text" name="query" class="form-control" onchange="filter(this.value)" placeholder="Search for users..."></input>
	</form>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>User ID</td>
				<td>Reason</td>
				<td>Banned at</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach($blacklistedUsers as $user)
				<tr>
					<td>{{ $user->user_id }}</td>
					<td>{{ $user->reason }}</td>
					<td>{{ $user->created_at }}</td>
					<td>
						<a class="btn btn-small btn-info" href="{{ URL::to('TheGreatWall/blacklist/' . $user->user_id . '/edit') }}">Edit</a>
						<form action="{{ action('BlacklistController@destroy', $user->user_id )}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="_method" value="delete">
							<input type="submit" value="Remove" class="btn btn-warning">
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	@if (empty($blacklistedUsers))
		<p class="alert alert-info">No blacklisted users.</p>
	@endif
@endsection
