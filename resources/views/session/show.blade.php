@extends('masterlayout')

@section('title', 'Session')

@section('page','moderate')

@section('header')

@stop

@section('content')
<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
<script>
	var socket = io('http://localhost:3000');
	socket.on('msg1.msg.{{$wall->id}}:App\\Events\\NewMessageEvent', function (data)
	{
		if (data.message.question_id == null)
		{
			var e = '<div>'+ +'</div>';
			$("#holder").append(e);
		}
		else if (data.message.question_id != null)
		{
			var e = '<div>'+ +'</div>';
			$("#holder").append(e);
		}
	});
	socket.on('msg1.polls.{{$wall->id}}:App\\Events\\NewPollEvent', function (data)
	{
		var e = '<div>'+ +'</div>';
		$("#holder").append(e);
	});
	socket.on('msg1.choice.polls.{{$wall->id}}:App\\Events\\NewPollChoiceEvent', function (data)
	{
		var e = '<div>'+ +'</div>';
		$("#holder").append(e);
	});
</script>
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
				<img class="right floated mini ui image" src="http://semantic-ui.com/images/avatar/large/elliot.jpg">
				<div class="header">
					{{ \App\User::find($post[1]->user_id)->name }}
				</div>
				<div class="meta">
					{{ $post[1]->wall->name }}
				</div>
				<div class="description">
					{{ $post[1]->text }}
				</div>
			</div>
			<div class="extra content">

				<div class="ui three buttons">
						<button type="submit" class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}" form="{{ "M_{$post[1]->id}_A" }}">Approve</button>
						<button type="submit" class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}" form="{{ "M_{$post[1]->id}_D" }}">Decline</button>
						<button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}" form="{{ "M_{$post[1]->id}_B" }}">Block</button>
				</div>

				<form method="post" action="{{ action('MessageController@accept') }}" id="{{ "M_{$post[1]->id}_A" }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
				</form>
				<form method="post" action="{{ action('MessageController@decline') }}" id="{{ "M_{$post[1]->id}_D" }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
				</form>
				<form method="get" action="{{action('BlacklistController@create')}}" id="{{ "M_{$post[1]->id}_B" }}">
					<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
				</form>
			</div>
		</div>
		@elseif($post[0]=='p')
		<div class="card">
			<div class="content">
				<img class="right floated mini ui image" src="http://semantic-ui.com/images/avatar/large/elliot.jpg">
				<div class="header">
					{{ \App\User::find($post[1]->user_id)->name }}
				</div>
				<div class="meta">
					{{ $post[1]->wall->name }}
				</div>
				<div class="description">
					{{ $post[1]->question }}
				</div>
			</div>
			<div class="extra content">

				<div class="ui three buttons">
						<button type="submit" class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}" form="{{ "P_{$post[1]->id}_A" }}">Approve</button>
						<button type="submit" class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}" form="{{ "P_{$post[1]->id}_D" }}">Decline</button>
						<button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}" form="{{ "P_{$post[1]->id}_B" }}">Block</button>
				</div>

				<!-- KAMIEL: FIX YOUR SHIT -->
				<form method="post" action="{{ action('MessageController@accept') }}" id="{{ "P_{$post[1]->id}_A" }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
				</form>
				<form method="post" action="{{ action('MessageController@decline') }}" id="{{ "P_{$post[1]->id}_D" }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="message_id" value="{{ $post[1]->id }}">
				</form>
				<form method="get" action="{{action('BlacklistController@create')}}" id="{{ "P_{$post[1]->id}_B" }}">
					<input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
				</form>
			</div>
		</div>
		@endif
	@endforeach
	</div>
</div>
=======

    <script>
        $(document).ready(function () {
            $(window).resize(function () {
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


        <div class="ui cards four stackable">
            @foreach($posts as $post)

                @if($post[0]=='m')
                    <div class="card">
                        <div class="content">
                            <img class="right floated mini ui image"
                                 src="http://semantic-ui.com/images/avatar/large/elliot.jpg">
                            <div class="header">
                                {{ \App\User::find($post[1]->user_id)->name }}
                            </div>
                            <div class="meta">
                                {{ $post[1]->wall->name }}
                            </div>
                            <div class="description">
                                {{ $post[1]->text }}
                                @if($post[1]->question)
                                    <div class="ui divider"></div>
                                    <div class="meta">Answer on message</div>
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
                            <img class="right floated mini ui image"
                                 src="http://semantic-ui.com/images/avatar/large/steve.jpg">
                            <div class="header">
                                {{ \App\User::find($post[1]->user_id)->name }}
                            </div>
                            <div class="meta">
                                {{ $post[1]->wall->name }}
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
                                    <img class="right floated mini ui image"
                                         src="http://semantic-ui.com/images/avatar/large/stevie.jpg">
                                    <div class="header">
                                        {{ \App\User::find($post[1]->user_id)->name }}
                                    </div>
                                    <div class="meta">
                                        {{ $post[1]->wall->name }}
                                    </div>
                                    <div class="description">
                                        {{ $choice->text }}
                                        <div class="ui divider"></div>
                                        <div class="meta">
                                           Answer on poll
                                        </div>
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
>>>>>>> master
@stop
