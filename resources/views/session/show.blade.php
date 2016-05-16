@extends('masterlayout')

@section('title', 'Session')

@section('page','moderate')

@section('header')

@stop

@section('content')

	<script>
		$(document).ready(function(){
			$(window).resize(function() {
				$(".stackable").removeClass('four').removeClass('three').removeClass('two');
				if ($(window).width() < 1000) {
					$(".stackable").addClass('two');
				}
				else if ($(window).width() < 1300) {
					$(".stackable").addClass('three');
				}
				else {
					$(".stackable").addClass('four');
				}
			});
		});
	</script>

	<div class="body_customized">
		<h1>Session: {{ $wall->name }}</h1>

		<div class="ui cards four stackable">
			@foreach($result as $row)
				<div class="card">
					<div class="content">
						<img class="right floated mini ui image" src="http://semantic-ui.com/images/avatar/large/elliot.jpg">
						<div class="header">
							{{ \App\User::find($row['user_id'])->name }}
						</div>
						<div class="meta">
							{{ $wall->name }}
						</div>
						<div class="description">
							{{ $row['text'] }}
						</div>
					</div>
					<div class="extra content">

						<div class="ui three buttons">
							@if($row['M'] == "M")
								<button type="submit" class="ui basic green button {{ $row['moderation_level'] == 0 ? "disabled" : "" }}" form="{{ "M_{$row['id']}_A" }}">Approve</button>
								<button type="submit" class="ui basic red button {{ $row['moderation_level'] == 1 ? "disabled" : "" }}" form="{{ "M_{$row['id']}_D" }}">Decline</button>
								<button class="ui basic grey button {{ in_array($row['user_id'], array_column($blacklistedUserIDs, 'user_id')) == 1 ? "disabled" : "" }}" form="{{ "M_{$row['id']}_B" }}">Block</button>
							@elseif($row['M'] == "P")
								<button type="submit" class="ui basic green button {{ $row['moderation_level'] == 0 ? "disabled" : "" }}" form="{{ "P_{$row['id']}_A" }}">Approve</button>
								<button type="submit" class="ui basic red button {{ $row['moderation_level'] == 1 ? "disabled" : "" }}" form="{{ "P_{$row['id']}_D" }}">Decline</button>
								<button class="ui basic grey button {{ in_array($row['user_id'], array_column($blacklistedUserIDs, 'user_id')) }}" form="{{ "P_{$row['id']}_B" }}">Block</button>
							@endif
						</div>

						<form method="post" action="{{ action('MessageController@accept') }}" id="{{ "M_{$row['id']}_A" }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="message_id" value="{{ $row['id'] }}">
						</form>
						<form method="post" action="{{ action('MessageController@decline') }}" id="{{ "M_{$row['id']}_D" }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="message_id" value="{{ $row['id'] }}">
						</form>
						<form method="get" action="{{action('BlacklistController@create')}}" id="{{ "M_{$row['id']}_B" }}">
							<input type="hidden" name="message_id" value="{{ $row['id'] }}">
						</form>

						<!-- KAMIEL: FIX YOUR SHIT -->
						<form method="post" action="{{ action('MessageController@accept') }}" id="{{ "P_{$row['id']}_A" }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="message_id" value="{{ $row['id'] }}">
						</form>
						<form method="post" action="{{ action('MessageController@decline') }}" id="{{ "P_{$row['id']}_D" }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="message_id" value="{{ $row['id'] }}">
						</form>
						<form method="get" action="{{action('BlacklistController@create')}}" id="{{ "P_{$row['id']}_B" }}">
							<input type="hidden" name="poll_id" value="{{ $row['id'] }}">
						</form>

					</div>
				</div>
			@endforeach
		</div>
	</div>
@stop
