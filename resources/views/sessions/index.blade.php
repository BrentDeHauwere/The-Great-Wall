@extends('master')

@section('title', 'Walls')

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>id</td>
				<td>user_id</td>
				<td>name</td>
				<td>password</td>
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
					<td>
						<a class="btn btn-small btn-success" href="{{ URL::to('TheGreatWall/sessions/' . $value->id) }}">Show this Wall</a>
						<a class="btn btn-small btn-info" href="{{ URL::to('TheGreatWall/sessions/' . $value->id . '/edit') }}">Edit this Wall</a>
						<form action="{{action('SessionController@destroy', $value->id)}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="_method" value="delete">
							<input type="submit" value="Delete the wall" class="btn btn-warning">
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection