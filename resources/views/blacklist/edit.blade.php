@extends('master')

@section('title', 'Edit Reason: ' . $blacklistedUser->user_id)

@section('content')
	<h1>Edit - {{ $blacklistedUser->user_id }}</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{action('BlacklistController@update', $blacklistedUser->user_id )}}" method="POST">
		<div class="form-group">
			<label for="reason">Reason</label>
			<input id="reason" type="text" name="reason" class="form-control" value="{{ $blacklistedUser->reason }}">
		</div>
    <input type="hidden" name="user_id" value="{{ $blacklistedUser->user_id }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="put">
		<input type="submit" value="Edit" class="btn btn-primary">
	</form>
@endsection
