@extends('masterlayout')

@section('title', 'Ban User')

@section('page','blacklist')

@section('content')
	<div class="body_customized">
		<h1>Ban User - {{ $username }}</h1>

		<form class="ui form" action="{{ action('BlacklistController@store') }}" method="post">
			<div class="field">
				<label for="reason">Reason</label>
				<input type="text" name="reason" placeholder="Reason" id="reason" autofocus="" value="{{ old('reason') }}">
			</div>
			<input type="hidden" name="user_id" value="{{ $user_id }}">
			<input type="hidden" name="message_id" value="{{ $message_id }}">
			<input type="hidden" name="poll_id" value="{{ $poll_id }}">
			{{ csrf_field() }}
			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
	</div>
@endsection
