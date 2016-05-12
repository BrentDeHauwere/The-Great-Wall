@extends('masterlayout')

@section('title', 'Blacklist')

@section('page','blacklist')

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<div class="body_customized">
		<table class="ui sortable celled table" id="table">
			<thead>
				<tr>
					<th>Username</th>
					<th>Reason</th>
					<th>Banned at</th>
					<th class="no-sort" style="width: 231px">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($blacklistedUsers as $user)
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->reason }}</td>
						<td>{{ $user->created_at }}</td>
						<td>
							<a class="ui basic button" href="{{ URL::to('blacklist/' . $user->user_id . '/edit') }}">
								<i class="icon edit"></i>
								Edit
							</a>
							<form action="{{ action('BlacklistController@destroy', $user->user_id )}}" method="post" class="form_inline_customize">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="_method" value="delete">
								<button class="ui basic red button" type="submit" style="margin-right: 0px">
									<i class="icon remove"></i>
									Remove
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@if (empty($blacklistedUsers))
		<p class="alert alert-info">No blacklisted users.</p>
	@endif

	<script src="/js/jquery.tablesort.js"></script>
	<script>
		$('#table').tablesort();
	</script>
@endsection
