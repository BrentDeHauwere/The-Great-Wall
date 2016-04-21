@extends('master')

@section('title', 'Edit Wall: ' . $wall->name)

@section('content')
	<h1>Edit - {{ $wall->name }}</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{action('SessionController@update')}}" method="post">
		<div class="form-group">
			<label for="user_id">UserID</label>
			<input id="user_id" type="number" name="user_id" class="form-control" value="{{ $wall->user_id }}">
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input id="name" type="text" name="name" class="form-control" value="{{ $wall->name }}">
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input id="password" type="password" name="password" class="form-control">
		</div>

		<div class="form-group">
			<label for="conf_password">Confirm password</label>
			<input id="conf_password" type="password" name="conf_password" class="form-control">
		</div>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<input type="hidden" name="_method" value="put">

		<input type="submit" value="Edit the wall" class="btn btn-primary">
	</form>
@endsection