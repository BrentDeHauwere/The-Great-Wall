@extends('master')

@section('title', 'Create Wall')

@section('content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{action('SessionController@store')}}" method="post">
		<div class="form-group">
			<label for="user_id">UserID</label>
			<input id="user_id" type="number" name="user_id" class="form-control">
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input id="name" type="text" name="name" class="form-control">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input id="password" type="password" name="password" class="form-control">
		</div>

		<input type="hidden" name="_token" value="{{csrf_token()}}">

		<input type="submit" value="Create the wall" class="btn btn-primary">
	</form>
@endsection