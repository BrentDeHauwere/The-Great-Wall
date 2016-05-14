@extends('masterlayout')

@section('title', 'Create Session')

@section('page','moderate')

@section('content')
	<div class="body_customized">
		<h1>Add Session</h1>

		<form class="ui form" action="{{action('SessionController@store')}}" method="post">

			<div class="field required">
				<label for="name">Name</label>
				<input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
				@helper('name')
			</div>

			<div class="field">
				<label for="password">Password</label>
				<input id="password" type="password" name="password" placeholder="Password">
				@helper('password')
			</div>

			<div class="field">
				<label for="password_confirmation">Confirm password</label>
				<input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password">
				@helper('password_confirmation')
			</div>

			<div class="field">
				<label for="open_until">Open until</label>
				<input id="open_until" type="datetime-local" name="open_until" value="{{ old('open_until') }}" placeholder="Open until">
				@helper('open_until')
			</div>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
	</div>
@endsection
