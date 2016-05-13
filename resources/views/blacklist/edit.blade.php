@extends('masterlayout')

@section('title', 'Edit Reason: ' . $blacklistedUser->user_id)

@section('page','blacklist')

@section('content')
	<h1>Edit - {{ $blacklistedUser->user->name }}</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{action('BlacklistController@update', $blacklistedUser->id)}}" method="post">
		<div class="form-group">
			<label for="reason">Reason</label>
			<input id="reason" type="text" name="reason" class="form-control" value="{{ $blacklistedUser->reason }}">
		</div>
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="put">
		<input type="hidden" name="user_id" value="{{$blacklistedUser->id}}">
		<input type="submit" value="Edit" class="btn btn-default">
	</form>
@endsection
