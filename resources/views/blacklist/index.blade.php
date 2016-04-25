@extends('masterlayout')

@section('title', 'Blacklist')

@section('page-script')
<script type="text/javascript">
	function filter(){
		alert('button clicked');
	};
</script>
@stop

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<div clas="row">
			<div class="col-sm-10">
				<input type="text" class="form-control" name="filter" placeholder="Filter by user id...">
			</div>
			<div class="col-sm-2">
				<button action="submit" name="filterbutton" class="btn btn-secondary btn-block" onclick="filter()">Filter</button>
			</div>
	</div>
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
