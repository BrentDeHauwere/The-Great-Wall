@extends('masterlayout')

@section('title', 'Blacklist')

@section('page','blacklist')

@section('page-script')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11/datatables.min.js"></script>
<script>
	$(document).ready( function () {
		//Initializeer de plugin
		$('#table').DataTable( {
			"columns" : [
				null,
				null,
				null,
				{ "searchable:" : false, "orderable" : false }
			] } );
} );
</script>
@stop

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<table class="table table-striped table-bordered" id="table">
		<thead>
			<tr>
				<td>Username</td>
				<td>Reason</td>
				<td>Banned at</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach($blacklistedUsers as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->reason }}</td>
					<td>{{ $user->created_at }}</td>
					<td>
						<a class="btn btn-small btn-info btn-block" href="{{ URL::to('blacklist/' . $user->user_id . '/edit') }}">Edit</a>
						<form action="{{ action('BlacklistController@destroy', $user->user_id )}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="_method" value="delete">
							<input type="submit" value="Remove" class="btn btn-danger btn-block">
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
