@extends('masterlayout')

@section('title', 'Edit Session: ' . $wall->name)

@section('page','moderate')

@section('content')
	<div class="body_customized">
		<h1>Edit - {{ $wall->name }}</h1>

		<form class="ui form" action="{{action('SessionController@update', $wall->id)}}" method="post">

			<div class="field required">
				<label for="name">Name</label>
				<input id="name" type="text" name="name" value="{{ $wall->name }}" placeholder="Name">
				@helper('name')
			</div>

			<div class="field required">
				<label for="name">Speaker</label>
				<div class="ui fluid selection dropdown required">
					<input type="hidden" name="speaker" value="{{ $wall->user_id }}">
					<i class="dropdown icon"></i>
					<div class="default text">Select Speaker</div>
					<div class="menu">
						@foreach($speakers as $speaker)
							@if($speaker->image == null)
								<div class="item" data-value="{{ $speaker->id }}">
									<i class="user icon"></i>
									{{ $speaker->name }}
								</div>
							@else
								<div class="item" data-value="{{ $speaker->id }}">
									<img class="ui mini avatar image" src="{{ $speaker->image }}">
									{{ $speaker->name }}
								</div>
							@endif
						@endforeach


					</div>
				</div>
				@helper('speaker')
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
				<input id="open_until" type="datetime-local" name="open_until" value="{{ $wall->open_until }}" placeholder="Open until">
				@helper('open_until')
			</div>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input type="hidden" name="_method" value="put">

			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
	</div>
@endsection
