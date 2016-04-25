@extends('masterlayout')

@section('title', 'Ban User')

@section('content')
	<h1>Ban user - {{ $user_id }}</h1>

	 @if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{ action('BlacklistController@store') }}" method="POST">
		<div class="form-group">
			<label for="reason">Reason</label>
			<input id="reason" type="text" name="reason" class="form-control" autofocus="">
		</div>
    <input type="hidden" name="user_id" value="{{ $user_id }}">
		<input type="hidden" name="message_id" value="{{ $message_id }}">
		<input type="hidden" name="poll_id" value="{{ $poll_id }}">
		{{ csrf_field() }}
		<input type="submit" value="Ban" class="btn btn-primary">
	</form>
@endsection
