@extends('masterlayout')

@section('title', 'Edit Reason: ' . $blacklistedUser->user_id)

@section('page','blacklist')

@section('content')
	<div class="body_customized">
		<h1>Edit - {{ $blacklistedUser->user->name }}</h1>

		<form class="ui form" action="{{action('BlacklistController@update', $blacklistedUser->id)}}" method="post">
			<div class="field">
				<label for="reason">Reason</label>
				<textarea name="reason" placeholder="Reason" id="reason" autofocus="">{{ $blacklistedUser->reason }}</textarea>
			</div>
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="put">
			<input type="hidden" name="user_id" value="{{$blacklistedUser->id}}">
			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
@endsection
