@extends("masterlayout")

@section('header')
<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
<script>
 var socket = io('http://socket.ehackb.be:3000');
 socket.on('msg1.msg:App\\Events\\NewMessageEvent',function(data){
   console.log("Message: " + data);
   console.log(data.message.wall_id);
   console.log(data.message.question_id);
	 if(data.message.question_id == null){
     var iets = "text:" + data.message.text + ".";
     console.log(iets);
   }
   else if(data.message.question_id != null){
     console.log(data.message.text);
     console.log($("#answers"+data.message.question_id));
     $("#answers"+data.message.question_id).after("<li>" + data.message.text + "</li>");
   }
 });
 socket.on('msg1.msg.vote:App\\Events\\NewMessageEvent',function(data){
   console.log("Message Vote: " + data);
   console.log(data.message.wall_id);
   console.log(data.message.question_id);
	 if(data.message.question_id == null){
     var iets = "text:" + data.message.text + ".";
     console.log(iets);
   }
   else if(data.message.question_id != null){
     console.log(data.message.text);
     console.log($("#answers"+data.message.question_id));
     $("#answers"+data.message.question_id).after("<li>" + data.message.text + "</li>");
   }
 });
 socket.on('msg1.polls:App\\Events\\NewPollEvent',function(data){
   console.log("Poll: " +data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.polls.choices:App\\Events\\NewPollEvent',function(data){
   console.log("Poll Choice: " +data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.polls.vote:App\\Events\\NewPollEvent',function(data){
   console.log("Poll Vote: " +data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.msg.moda:App\\Events\\NewMessageModeratorAcceptedEvent',function(data){
   console.log("Moderator Message Accepted: " + data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.msg.modd:App\\Events\\NewMessageModeratorDeclinedEvent',function(data){
   console.log("Moderator Message Declined: " +data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.polls.moda:App\\Events\\NewMessageModeratorAcceptedEvent',function(data){
   console.log("Moderator Poll Accepted: " + data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
 socket.on('msg1.polls.modd:App\\Events\\NewMessageModeratorDeclinedEvent',function(data){
   console.log("Moderator Poll Declined: " +data);
   console.log(data.poll.wall_id);
   console.log(data.poll.question_id);
 });
</script>
<link rel="stylesheet" type="text/css" href="/css/messagewall.css">
<script src="http://malsup.github.com/jquery.form.js"></script>
@stop

@section('title', 'The Great Wall')

@section('page','home')

@section('content')
	<div class=" container messagesContainer center-block ">
		<h3>{{$wall->name}}</h3>

		<!-- Voorbeeld Form om nieuwe message aan te maken -->
		<div id="messageForm" class="message">
			<form method="POST" action="/message">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="panel panel-default">
					<div class="panel-heading">
						<!-- input group -->
						<div class="btn-group">
							<button type="button" class="btn btn-default messageButton">
								Bericht
							</button>
							<button type="button" class="btn btn-default pollButton">
								Poll
							</button>
						</div>
					</div>
					<div class="panel-body messageBody">
							<textarea class="form-control" name="text" id="" cols="30" rows="5"
									  placeholder="Plaats hier uw vraag"></textarea>
						<input type="hidden" name="anonymous" value=0>
						<input type="checkbox" name="anonymous" value=1> Anoniem

						<div class="buttons pull-right submitButton" role="group">
							<input type="submit" class="btn btn-default" value="Posten">
						</div>
					</div>
				</div>

				<input type="hidden" name="user_id" value="{{1}}">
				<input type="hidden" name="wall_id" value="{{$wall->id}}">
				<input type="hidden" name="channel_id" value="{{1}}">
			</form>
		</div>

		<!-- Form om nieuwe poll aan te maken -->
		<div id="pollForm" class="poll">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="btn-group">
						<button type="button" class="btn btn-default messageButton">
							Bericht
						</button>
						<button type="button" class="btn btn-default pollButton">
							Poll
						</button>
					</div>
				</div>
				<div class="panel-body messageBody">
					<form id="formPoll" method="POST" action="/poll">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="user_id" value="{{1}}">
						<input type="hidden" name="wall_id" value="{{$wall->id}}">

						<input class="form-control" type="text" name="question"
							   placeholder="Plaats hier uw vraag">

						<ul class="list-group" id="pollChoices">

						</ul>

						<div class="input-group">
							<input id="pollChoiceText" type="text" class="form-control" placeholder="Plaats hier uw optie">
							<span class="input-group-btn">
								<button class="btn btn-secondary" type="button" id="addPollChoice">Toevoegen</button>
							</span>
						</div>

						<input type="hidden" name="addable" value=0>
						<input type="checkbox" name="addable" value=1> Keuzes toe te
						voegen

						<div class="buttons pull-right submitButton" role="group">
							<input type="submit" class="btn btn-default" value="Posten">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

		@foreach($posts as $post)

		@if($post[0]=='m')
		@if(empty($post[1]->question_id))
			<!-- message -->
		<div class="row message">
			<div class="panel panel-default">
				<div class="panel-heading">
					<!-- upvote -->
					<div class="buttons pull-right">

						<a class="">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</a>
					</div>
					<h4 class="panel-title">
						@unless($post[1]->anonymous)
							{{$post[1]->user_id}}
							@else
								Anoniem
								@endunless
								<small>at {{$post[1]->created_at}}</small>
					</h4>
				</div>
				<div class="panel-body messageBody">
					<p>{{$post[1]->text}}</p>
				</div>

				<!-- antwoorden -->
				@unless($post[1]->answers->isEmpty())
					<ul id="answers{{ $post[1]->id }}" class="list-group">
						@foreach($post[1]->answers->where('moderation_level',0) as $answer)
							<li class="list-group-item">
								<!-- upvote -->
								<div class="buttons pull-right">
									<form>
										<input type="hidden" name="message_id" value={{$post[1]->id}}>
										<!-- ID of the logged-in user -->
										<input type="hidden" name="user_id" value={{1}}>
										<button type="submit" class="form-control upvote active">
											<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
										</button>
									</form>
								</div>
								<b>
									@unless($answer->anonymous)
										{{$answer->user_id}}
										@else
											Anoniem
											@endunless
											<small> at {{$answer->created_at}}</small>
								</b>
								<p class="answer">{{$answer->text}}</p>
							</li>
						@endforeach
					</ul>
					@endunless

						<!-- antwoord toevoegen -->
					<form method="POST" action="/message">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="question_id" value="{{$post[1]->id}}">
						<input type="hidden" name="channel_id" value="{{1}}">
						<input type="hidden" name="user_id" value="{{1}}">
						<input type="hidden" name="wall_id" value="{{$wall->id}}">
						<div class="input-group">
							<div class="input-group-addon input-wall">
								Anoniem
								<input type="hidden" name="anonymous" value=0>
								<input type="checkbox" name="anonymous" value=1>
							</div>
							<input name="text" type="text" class="form-control input-wall" placeholder="Uw antwoord">
							<span class="input-group-btn">
								 <input type="submit" class="btn btn-default input-wall" value="Antw.">
							 </span>
						</div>
					</form>
			</div>
		</div>
		@endif

		@elseif($post[0]=='p')
			<!-- poll -->
		<div class="row message poll">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">{{$post[1]->user_id}}
						<small>{{$post[1]->created_at}}</small>
					</h4>
				</div>
				<div class="panel-body messageBody">
					<p>{{$post[1]->question}}</p>
				</div>

				<!-- verschillende antwoorden -->
				<div class="choiceContainer row">
					<?php
					$total = 0;
					foreach ($post[1]->choices->where('moderation_level', 0) as $choice)
					{
						$total += $choice->count;
					}
					?>
					@forelse($post[1]->choices as $choice)

						<div class="choices col-md-12">
							<div class="col-md-4 col-sm-4">
								<form method="POST" action="/votepoll">
									<!-- OK button -->
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="poll_choice_id" value={{$choice->id}}>
									<input type="hidden" name="user_id" value={{1}}>
									<button type="submit" class="btn btn-default vote">
										<span class="glyphicon glyphicon-ok" area-hidden="true"></span>
									</button>
									<span class="progress-opt">{{$choice->text}}</span>
								</form>
							</div>

							<div class="col-md-6 col-sm-6">
								<div class="progress">
									<?php
									if ( $total != 0 )
									{
										$percentage = round($choice->count / $total * 100);
									}
									else
									{
										$percentage = 0;
									}
									?>

									<div class="progress-bar" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0"
										 aria-valuemax="100" style="width: {{$percentage}}%;">
										{{$percentage}}%
									</div>
								</div>
							</div>

							<div class="col-md-1 col-sm-1">
								<span class="progress-votes">{{$choice->count}}</span>
							</div>
						</div>
					@empty
						<h3 class="text-center">Er zijn geen mogelijke opties
							ingesteld :(</h3>
					@endforelse
				</div>

				@if($post[1]->addable)
					<!-- antwoord toevoegen -->
				<form method="POST" action="{{ action("PollChoiceController@store") }}">
					<div class="input-group">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="user_id" value={{1}}>
						<input type="hidden" name="poll_id" value={{$post[1]->id}}>
						<input type="text"  name="text" class="form-control" placeholder="Uw antwoord">
							<span class="input-group-btn">
								 <button class="btn btn-default" type="submit">
									 Antw.
								 </button>
							 </span>
					</div>
				</form>
				@endif
			</div>
		</div>
		@endif
		@endforeach
@stop


@section('footer')
	<script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
	<script>
		var nextPage = 1;
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() == $(document).height()){
				console.log("botoom");
				var url = $(location).attr('href');
				var request = $.ajax({
					method: "GET",
					url: url + "?page=" + nextPage,
					contentType: "html",
					success : function(html){
						nextPage += 1;
						console.log("ajax done");
						$("body").append(html);
					}
				});
			}
		});
	</script>
@stop
