@extends("masterlayout")

@section('header')
	<link rel="stylesheet" type="text/css" href="/css/messagewall.css">

	<script src="https://10.3.50.20:1338/socket.io/socket.io.js"></script>
	<script>
		var socket = io('http://10.3.50.20:1338');

		socket.on('msg1.msg.{{$wall->id}}:App\\Events\\NewMessageEvent', function (data)
		{
			console.log(data);
			console.log("Message: " + data);
			if (data.message.question_id == null)
			{
				var iets = "text:" + data.message.text + ".";
				console.log(iets);
			}
			else if (data.message.question_id != null)
			{
				console.log(data.message.text);
				console.log($("#answers" + data.message.question_id));
				$("#answers" + data.message.question_id).after("<li>" + data.message.text + "</li>");
			}
		});
		socket.on('msg1.vote.msg.{{$wall->id}}:App\\Events\\NewMessageVoteEvent', function (data)
		{
			console.log(data);
			console.log("Message Vote: " + data);
			if (data.message.question_id == null)
			{
				var iets = "text:" + data.message.text + ".";
			}
			else if (data.message.question_id != null)
			{
				$("#answers" + data.message.question_id).after("<li>" + data.message.text + "</li>");
			}
		});
		socket.on('msg1.polls.{{$wall->id}}:App\\Events\\NewPollEvent', function (data)
		{
			console.log(data);
			console.log("Poll: " + data);
		});
		socket.on('msg1.choice.polls.{{$wall->id}}:App\\Events\\NewPollChoiceEvent', function (data)
		{
			console.log(data);
			console.log("Poll Choice: " + data);
		});
		socket.on('msg1.vote.polls.{{$wall->id}}:App\\Events\\NewPollVoteEvent', function (data)
		{
			console.log(data);
			console.log("Poll Vote: " + data);
		});
		socket.on('msg1.moda.msg.{{$wall->id}}:App\\Events\\NewMessageModeratorAcceptedEvent', function (data)
		{
			console.log(data);
			console.log("Moderator Message Accepted: " + data);
		});
		socket.on('msg1.modd.msg.{{$wall->id}}:App\\Events\\NewMessageModeratorDeclinedEvent', function (data)
		{
			console.log(data);
			console.log("Moderator Message Declined: " + data);
		});
		socket.on('msg1.moda.polls.{{$wall->id}}:App\\Events\\NewPollModeratorAcceptedEvent', function (data)
		{
			console.log(data);
			console.log("Moderator Poll Accepted: " + data);
		});
		socket.on('msg1.modd.polls.{{$wall->id}}:App\\Events\\NewPollModeratorDeclinedEvent', function (data)
		{
			console.log(data);
			console.log("Moderator Poll Declined: " + data);
		});
		</script>
		
	<script>
		$(document).ready(function ()
		{
			$('.menu .item')
				.tab()
			;

			$('.ui.checkbox')
				.checkbox()
			;


			$('.tab').on('click', '.poll_option_add', function ()
			{
				$(this).children().removeClass("plus icon");
				$(this).children().addClass("minus icon");
				$(this).removeClass("blue");
				$(this).addClass("red");

				$(this).removeClass("poll_option_add");
				$(this).addClass("poll_option_remove");

				$('<div class="field"><div class="ui action input poll_option"><input name="choices[]" type="text" placeholder="Answer"><button type="button" class="ui blue right icon button poll_option_add"> <i class="plus icon"></i> </button> </div> </div>')
					.insertBefore('#poll_submit');
			})

			$('.tab').on('click', '.poll_option_remove', function ()
			{
				$(this).closest('.field').remove();
			})
		});
	</script>
@stop

@section('title', 'The Great Wall')

@section('page','home')

@section('content')
	<div class="body_customized">
		<h1>{{$wall->name}}</h1>

		<div class="ui top attached tabular menu">
			<a class="item active" data-tab="message">Post Message</a>
			<a class="item" data-tab="poll">Post Poll</a>
		</div>
		<div class="ui bottom attached tab segment" data-tab="message">
			<form method="POST" action="/message">
				<div class="ui form">
					<div class="field">
						<label>Message</label>
						<textarea rows="2" name="text"></textarea>
					</div>
					<div class="inline field group">
						<div class="ui checkbox">
							<input type="hidden" name="anonymous" value=0>
							<input type="checkbox" name="anonymous" value="1" tabindex="0" class="hidden">
							<label>Anonymous</label>
						</div>
						<button class="ui button primary right floated" type="submit">Submit</button>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
				<input type="hidden" name="wall_id" value="{{$wall->id}}">
				<input type="hidden" name="channel_id" value="{{1}}">
			</form>
		</div>
		<div class="ui bottom attached tab segment" data-tab="poll">
			<div class="ui form">
				<form id="formPoll" method="POST" action="/poll">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
					<input type="hidden" name="wall_id" value="{{$wall->id}}">
					<input type="hidden" name="channel_id" value={{1}}>

					<div class="field">
						<label>Poll</label>
						<textarea rows="2" name="question" placeholder="Question"></textarea>
					</div>
					<div class="field">
						<label>Answers</label>
						<div class="ui action input poll_option">
							<input type="text" placeholder="Answer" name="choices[]">
							<button type="button" class="ui blue right icon button poll_option_add">
								<i class="plus icon"></i>
							</button>
						</div>
					</div>
					<div class="inline field group" id="poll_submit">
						<div class="ui checkbox">
							<input type="hidden" name="addable" value=0>
							<input type="checkbox" name="addable" value=1 tabindex="0" class="hidden">
							<label>Can add options</label>
						</div>
						<button class="ui button primary right floated" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>

		@include("/wall/posts", array("posts" => $posts))

		<div id="append"></div>
	</div>
@stop


@section('footer')
	<script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
	<script>
		var nextPage = 2;
		$(window).scroll(function ()
		{
			if ($(window).scrollTop() + $(window).height() == $(document).height())
			{
				console.log("botoom");
				var url = "/wall/update/{{ $wall->id }}";//$(location).attr('href');
				console.log(url);
				var request = $.ajax({
					method     : "GET",
					url        : url + "?page=" + nextPage,
					contentType: "html",
					success    : function (html)
					{
						nextPage += 1;
						console.log("ajax done");
						$("#append").append(html);
					}
				});
			}
		});
	</script>
@stop
