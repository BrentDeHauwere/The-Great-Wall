@extends('masterlayout')

@section('title', 'Session')

@section('page','moderate')

@section('header')

<script src="http://127.0.0.1:1338/socket.io/socket.io.js"></script>
@if(!empty($wall))
	<script>
		var socket = io('http://localhost:1338/');
		socket.on('msg1.msg.{{$wall->id}}:App\\Events\\NewMessageEvent', function (data)
		{
			if (data.question == null)
			{
				console.log(data.message);
				var token = $('#token').val();
				var e = '<div class="card">';
				e += '<div class="content">';
				e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
				e += '<div class="header">' + data.user.name + '</div>';
				e += '<div class="meta"><i class="comment icon"></i>' + data.wall.name + '</div>';
				e += '<div class="description">' + data.message.text + '</div>';
				e += '</div>';
				e += '<div class="extra content">';
				e += '<div class="ui three buttons">';
				e += '<button type="submit" class="ui basic green button" form="M_'+data.message.id+'_A">Approve</button>';
				e += '<button type="submit" class="ui basic red button" form="M_'+data.message.id+'_D">Decline</button>';
				e += '<button type="submit" class="ui basic grey button" form="M_'+data.message.id+'_B">Block</button>';
				e += '</div>';
				e += '<form method="post" action="/message/accept" id="M_'+data.message.id+'_A">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="post" action="/message/decline" id="M_'+data.message.id+'_D">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="get" action="/blacklist/create" id="M_'+data.user.id+'_B">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form>';
				e += '</div>';
				e += '</div>';
				$(e).prependTo("#holder").hide().fadeIn(2000);
			}
			else if (data.question != null)
			{
				console.log(data);
				var token = $('#token').val();
				var e = '<div class="card">';
				e += '<div class="content">';
				e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
				e += '<div class="header">' + data.user.name + '</div>';
				e += '<div class="meta"><i class="comments icon"></i>' + data.wall.name + '</div>';
				e += '<div class="description">' + data.message.text;
				e += '<div class="ui divider"></div>';
				e += '<div class="meta">Answer on message</div>';
				e += data.question.text;
				e += '</div>';
				e += '</div>';
				e += '<div class="extra content">';
				e += '<div class="ui three buttons">';
				e += '<button type="submit" class="ui basic green button" form="M_'+data.message.id+'_A">Approve</button>';
				e += '<button type="submit" class="ui basic red button" form="M_'+data.message.id+'_D">Decline</button>';
				e += '<button class="ui basic grey button" form="M_'+data.message.id+'_B">Block</button>';
				e += '</div>';
				e += '<form method="post" action="/message/accept" id="M_'+data.message.id+'_A">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="post" action="/message/decline" id="M_'+data.message.id+'_D">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="' + data.message.id + '">';
				e += '</form><form method="get" action="/blacklist/create" id="M_'+data.message.id+'_B">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form>';
				e += '</div>';
				e += '</div>';
				$(e).prependTo("#holder").hide().fadeIn(2000);
			}
		});
		socket.on('msg1.polls.{{$wall->id}}:App\\Events\\NewPollEvent', function (data)
		{
			console.log(data);
			var token = $('#token').val();
			var e = '<div class="card">';
			e += '<div class="content">';
			e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
			e += '<div class="header">'+ data.user.name +'</div>';
			e += '<div class="meta"><i class="tasks icon"></i>'+ data.wall.name+'</div>';
			e += '<div class="description">'+data.poll.question;
			e += '</div></div>';
			e += '<div class="extra content">';
			e += '<div class="ui three buttons">';
			e += '<button type="submit" class="ui basic green button" form="P_'+ data.poll.id +'_A">Approve</button>';
			e += '<button type="submit" class="ui basic red button" form="P_'+data.poll.id+'_D">Decline</button>';
			e += '<button class="ui basic grey button" form="P_'+data.poll.id+'_B">Block</button>';
			e += '</div>';
			e += '<form method="post" action="/poll/accept" id="P_'+data.poll.id+'_A">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form><form method="post" action="/poll/decline" id="P_'+data.poll.id+'_D">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form><form method="get" action="/blacklist/create" id="P_'+data.poll.id+'_B">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form>';
			e += '</div>';
			e += '</div>';
			$(e).prependTo("#holder").hide().fadeIn(2000);
		});
		socket.on('msg1.choice.polls.{{$wall->id}}:App\\Events\\NewPollChoiceEvent', function (data)
		{
			console.log(data);
			var token = $('#token').val();
			var e = '<div class="card">';
			e += '<div class="content">';
			e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
			e += '<div class="header">' + data.user.name + '</div>';
			e += '<div class="meta"><i class="tasks icon"></i>'+data.wall.name+'</div>';
			e += '<div class="description">'+data.poll_choice.text;
			e += '<div class="ui divider"></div>';
			e += '<div class="meta">Answer on poll</div>';
			e += data.poll.question;
			e += '</div>';
			e += '</div>';
			e += '<div class="extra content">';
			e += '<div class="ui three buttons">';
			e += '<button type="submit" class="ui basic green button" form="PC_'+data.poll_choice.id+'_A">Approve</button>';
			e += '<button type="submit" class="ui basic red button" form="PC_'+data.poll_choice.id+'_D">Decline</button>';
			e += '<button class="ui basic grey button" form="PC_'+data.poll_choice.id+'_B">Block</button>';
			e += '</div>';
			e += '<form method="post" action="/message/accept" id="PC_'+data.poll_choice.id+'_A">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="'+data.poll_choice.id+'">';
			e += '</form><form method="post" action="/message/decline" id="PC_'+data.poll_choice.id+'_D">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="' + data.poll_choice.id + '">';
			e += '</form><form method="get" action="/blacklist/create" id="PC_'+data.poll_choice.id+'_B">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="'+data.poll_choice.id+'">';
			e += '</form>';
			e += '</div>';
			e += '</div>';
			$(e).prependTo("#holder").hide().fadeIn(2000);
		});
</script>
@else
	@foreach($walls as $wall)
	<script>
		var socket = io('http://localhost:1338');
		socket.on('msg1.msg.{{$wall->id}}:App\\Events\\NewMessageEvent', function (data)
		{
			if (data.question == null)
			{
				console.log(data.message);
				var token = $('#token').val();
				var e = '<div class="card">';
				e += '<div class="content">';
				e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
				e += '<div class="header">' + data.user.name + '</div>';
				e += '<div class="meta"><i class="comment icon"></i>' + data.wall.name + '</div>';
				e += '<div class="description">' + data.message.text + '</div>';
				e += '</div>';
				e += '<div class="extra content">';
				e += '<div class="ui three buttons">';
				e += '<button type="submit" class="ui basic green button" form="M_'+data.message.id+'_A">Approve</button>';
				e += '<button type="submit" class="ui basic red button" form="M_'+data.message.id+'_D">Decline</button>';
				e += '<button type="submit" class="ui basic grey button" form="M_'+data.message.id+'_B">Block</button>';
				e += '</div>';
				e += '<form method="post" action="/message/accept" id="M_'+data.message.id+'_A">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="post" action="/message/decline" id="M_'+data.message.id+'_D">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="get" action="/blacklist/create" id="M_'+data.user.id+'_B">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form>';
				e += '</div>';
				e += '</div>';
				$(e).prependTo("#holder").hide().fadeIn(2000);
			}
			else if (data.question != null)
			{
				console.log(data);
				var token = $('#token').val();
				var e = '<div class="card">';
				e += '<div class="content">';
				e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
				e += '<div class="header">' + data.user.name + '</div>';
				e += '<div class="meta"><i class="comments icon"></i>' + data.wall.name + '</div>';
				e += '<div class="description">' + data.message.text;
				e += '<div class="ui divider"></div>';
				e += '<div class="meta">Answer on message</div>';
				e += data.question.text;
				e += '</div>';
				e += '</div>';
				e += '<div class="extra content">';
				e += '<div class="ui three buttons">';
				e += '<button type="submit" class="ui basic green button" form="M_'+data.message.id+'_A">Approve</button>';
				e += '<button type="submit" class="ui basic red button" form="M_'+data.message.id+'_D">Decline</button>';
				e += '<button class="ui basic grey button" form="M_'+data.message.id+'_B">Block</button>';
				e += '</div>';
				e += '<form method="post" action="/message/accept" id="M_'+data.message.id+'_A">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form><form method="post" action="/message/decline" id="M_'+data.message.id+'_D">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="' + data.message.id + '">';
				e += '</form><form method="get" action="/blacklist/create" id="M_'+data.message.id+'_B">';
				e += '<input type="hidden" name="_token" value="' + token + '">';
				e += '<input type="hidden" name="message_id" value="'+data.message.id+'">';
				e += '</form>';
				e += '</div>';
				e += '</div>';
				$(e).prependTo("#holder").hide().fadeIn(2000);
			}
		});
		socket.on('msg1.polls.{{$wall->id}}:App\\Events\\NewPollEvent', function (data)
		{
			console.log(data);
			var token = $('#token').val();
			var e = '<div class="card">';
			e += '<div class="content">';
			e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
			e += '<div class="header">'+ data.user.name +'</div>';
			e += '<div class="meta"><i class="tasks icon"></i>'+ data.wall.name+'</div>';
			e += '<div class="description">'+data.poll.question;
			e += '</div></div>';
			e += '<div class="extra content">';
			e += '<div class="ui three buttons">';
			e += '<button type="submit" class="ui basic green button" form="P_'+ data.poll.id +'_A">Approve</button>';
			e += '<button type="submit" class="ui basic red button" form="P_'+data.poll.id+'_D">Decline</button>';
			e += '<button class="ui basic grey button" form="P_'+data.poll.id+'_B">Block</button>';
			e += '</div>';
			e += '<form method="post" action="/poll/accept" id="P_'+data.poll.id+'_A">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form><form method="post" action="/poll/decline" id="P_'+data.poll.id+'_D">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form><form method="get" action="/blacklist/create" id="P_'+data.poll.id+'_B">';
			e += '<input type="hidden" name="_token" value="'+token+'">';
			e += '<input type="hidden" name="message_id" value="'+data.poll.id+'">';
			e += '</form>';
			e += '</div>';
			e += '</div>';
			$(e).prependTo("#holder").hide().fadeIn(2000);
		});
		socket.on('msg1.choice.polls.{{$wall->id}}:App\\Events\\NewPollChoiceEvent', function (data)
		{
			console.log(data);
			var token = $('#token').val();
			var e = '<div class="card">';
			e += '<div class="content">';
			e += '<img class="right floated mini ui image" src="/user_images/'+data.user.id+'">';
			e += '<div class="header">' + data.user.name + '</div>';
			e += '<div class="meta"><i class="tasks icon"></i>'+data.wall.name+'</div>';
			e += '<div class="description">'+data.poll_choice.text;
			e += '<div class="ui divider"></div>';
			e += '<div class="meta">Answer on poll</div>';
			e += data.poll.question;
			e += '</div>';
			e += '</div>';
			e += '<div class="extra content">';
			e += '<div class="ui three buttons">';
			e += '<button type="submit" class="ui basic green button" form="PC_'+data.poll_choice.id+'_A">Approve</button>';
			e += '<button type="submit" class="ui basic red button" form="PC_'+data.poll_choice.id+'_D">Decline</button>';
			e += '<button class="ui basic grey button" form="PC_'+data.poll_choice.id+'_B">Block</button>';
			e += '</div>';
			e += '<form method="post" action="/message/accept" id="PC_'+data.poll_choice.id+'_A">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="'+data.poll_choice.id+'">';
			e += '</form><form method="post" action="/message/decline" id="PC_'+data.poll_choice.id+'_D">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="' + data.poll_choice.id + '">';
			e += '</form><form method="get" action="/blacklist/create" id="PC_'+data.poll_choice.id+'_B">';
			e += '<input type="hidden" name="_token" value="' + token + '">';
			e += '<input type="hidden" name="message_id" value="'+data.poll_choice.id+'">';
			e += '</form>';
			e += '</div>';
			e += '</div>';
			$(e).prependTo("#holder").hide().fadeIn(2000);
		});
	</script>
	@endforeach
	<?php $wall = null ?>
@endif
@stop

@section('content')
	<input type="hidden" id="token" value="{{ csrf_token() }}" />
	<script>
		$(document).ready(function ()
		{
			$(window).resize(function ()
			{
				$(".stackable").removeClass('four').removeClass('three').removeClass('two');
				if ($(window).width() < 1000)
				{
					$(".stackable").addClass('two');
				}
				else if ($(window).width() < 1300)
				{
					$(".stackable").addClass('three');
				}
				else
				{
					$(".stackable").addClass('four');
				}
			});
		});
	</script>
	<div class="body_customized">
		@if(isset($wall))
			<h1>Session: {{ $wall->name }}</h1>
		@else
			<h1>
				Sessions:
				{{ $walls[0]->name }}
				@for($i = 1;$i < $walls->count();$i++)
					{{ ", ".$walls[$i]->name}}
				@endfor
			</h1>
		@endif


		<div class="ui cards four stackable" id="holder">
			@foreach($posts as $post)

				@if($post[0]=='m')
					<div class="card">
						<div class="content">
							<img class="right floated mini ui image" src="{{ route('user_images', ['filename' => $post[1]->user->id]) }}">
							<div class="header">
								{{ \App\User::find($post[1]->user_id)->name }}
							</div>
							<div class="meta">
								@if($post[1]->question)
									<i class="comments icon"></i>
								@else
									<i class="comment icon"></i>
								@endif
								{{ $post[1]->wall->name }}
							</div>
							<div class="description">
								{{ $post[1]->text }}
								@if($post[1]->question)
									<div class="ui divider"></div>
									{{$post[1]->question->text}}
								@endif
							</div>
						</div>
						<div class="extra content">

							<div class="ui three buttons">
								<button type="submit"
										class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}"
										form="{{ "M_{$post[1]->id}_A" }}">Approve
								</button>
								<button type="submit"
										class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}"
										form="{{ "M_{$post[1]->id}_D" }}">Decline
								</button>
								<button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
										form="{{ "M_{$post[1]->id}_B" }}">Block
								</button>
							</div>

							<form method="post" action="{{ action('MessageController@accept') }}"
								  id="{{ "M_{$post[1]->id}_A" }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
							</form>
							<form method="post" action="{{ action('MessageController@decline') }}"
								  id="{{ "M_{$post[1]->id}_D" }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
							</form>
							<form method="get" action="{{action('BlacklistController@create')}}"
								  id="{{ "M_{$post[1]->id}_B" }}">
								<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
							</form>
						</div>
					</div>

				@elseif($post[0]=='p')
					<div class="card">
						<div class="content">

							<img class="right floated mini ui image" src="{{ route('user_images', ['filename' => $post[1]->user->id]) }}">

							<div class="header">
								{{ \App\User::find($post[1]->user_id)->name }}
							</div>
							<div class="meta">
								<i class="tasks icon"></i> {{ $post[1]->wall->name }}
							</div>
							<div class="description">
								{{ $post[1]->question }}
							</div>
						</div>
						<div class="extra content">

							<div class="ui three buttons">
								<button type="submit"
										class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}"
										form="{{ "P_{$post[1]->id}_A" }}">Approve
								</button>
								<button type="submit"
										class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}"
										form="{{ "P_{$post[1]->id}_D" }}">Decline
								</button>
								<button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
										form="{{ "P_{$post[1]->id}_B" }}">Block
								</button>
							</div>

							<form method="post" action="{{ action('PollController@accept') }}"
								  id="{{ "P_{$post[1]->id}_A" }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
							</form>
							<form method="post" action="{{ action('PollController@decline') }}"
								  id="{{ "P_{$post[1]->id}_D" }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
							</form>
							<form method="get" action="{{action('BlacklistController@create')}}"
								  id="{{ "P_{$post[1]->id}_B" }}">
								<input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
							</form>
						</div>
					</div>

					@if($post[1]->choices)
						@foreach($post[1]->choices as $choice)
							<div class="card">
								<div class="content">

									<img class="right floated mini ui image" src="{{ route('user_images', ['filename' => $post[1]->user->id]) }}">

									<div class="header">
										{{ \App\User::find($post[1]->user_id)->name }}
									</div>
									<div class="meta">
										<i class="tasks icon"></i> {{ $post[1]->wall->name }}
									</div>
									<div class="description">
										{{ $choice->text }}
										<div class="ui divider"></div>
										{{$post[1]->question}}
									</div>
								</div>
								<div class="extra content">

									<div class="ui three buttons">

										<!-- WIP -->

										<button type="submit"
												class="ui basic green button {{ $choice->moderation_level == 0 ? "disabled" : "" }}"
												form="{{ "P_{$choice->id}_A" }}">Approve
										</button>
										<button type="submit"
												class="ui basic red button {{ $choice->moderation_level == 1 ? "disabled" : "" }}"
												form="{{ "P_{$choice->id}_D" }}">Decline
										</button>

										<button class="ui basic grey button {{ in_array($choice->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
												form="{{ "P_{$choice->id}_B" }}">Block
										</button>
									</div>

									<form method="post" action="{{ action('PollChoiceController@accept') }}"
										  id="{{ "P_{$choice->id}_A" }}">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="poll_choice_id" value="{{ $choice->id }}">
									</form>
									<form method="post" action="{{ action('PollChoiceController@decline') }}"
										  id="{{ "P_{$choice->id}_D" }}">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="poll_choice_id" value="{{ $choice->id }}">
									</form>
									<form method="get" action="{{action('BlacklistController@create')}}"
										  id="{{ "P_{$choice->id}_B" }}">
										<input type="hidden" name="poll_choice_id" value="{{ $choice->id }}">
									</form>
								</div>
							</div>
						@endforeach
					@endif
				@endif
			@endforeach
		</div>
	</div>
@stop
