@extends('masterlayout')

@section('title', 'Walls')

@section('page','moderate')

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>User ID</td>
				<td>Name</td>
				<td>Protected</td>
				<td>Open until</td>
				<td>Actions</td>
			</tr>
		</thead>
		<tbody>
			@foreach($walls as $key => $value)
				<tr>
					<td>{{ $value->id }}</td>
					<td>{{ $value->user_id }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->password }}</td>
					<td>{{ $value->open_until }}</td>
					<td>
							<a class="btn btn-success btn-block" href="{{ action('SessionController@show', $value->id) }}">Show</a>
							<a class="btn btn-info btn-block" href="{{ action('SessionController@edit', $value->id) }}">Edit</a>
							<form action="{{action('SessionController@destroy', $value->id)}}" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
								<input type="hidden" name="_method" value="delete"/>
								<button type="submit" class="btn btn-danger btn-block" style="margin-top: 5px">Close</button>
							</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<a class="btn btn-success btn-block" href="{{ action('SessionController@create') }}">Add Session</a>
	<a class="btn btn-success btn-block" href="{{ action('BlacklistController@index') }}">Go to Blacklist</a>
@endsection
