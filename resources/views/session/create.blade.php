@extends('masterlayout')

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
			<input id="user_id" type="number" name="user_id" class="form-control" value="{{ old('user_id') }}">
			@helper('user_id')
		</div>

		<div class="form-group">
			<label for="name">Name</label>
			<input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
			@helper('name')
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input id="password" type="password" name="password" class="form-control">
			@helper('password')
		</div>

		<div class="form-group">
			<label for="password_confirmation">Confirm password</label>
			<input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
			@helper('password_confirmation')
		</div>

		<div class="form-group">
			<label for="open_until">Open until</label>
			<input id="open_until" type="datetime-local" name="open_until" class="form-control" value="{{ old('open_until') }}">
			@helper('open_until')
		</div>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<input type="submit" value="Create the wall" class="btn btn-default">
	</form>
@endsection
