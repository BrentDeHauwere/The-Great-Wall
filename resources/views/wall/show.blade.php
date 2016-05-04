@extends("masterlayout")
@section('header')
<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
<script>
 var socket = io('http://localhost:3000');
 socket.on('test-channel:App\\Events\\NewMessageEvent',function(message){
	 console.log(message);
 });
</script>
@stop

@section('title', 'The Great Wall')

@section('content')

	<div class=" container messagesContainer center-block">
		<h3 id="title">{{$wall->name}}</h3>

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
					<ul class="list-group">
						@foreach($post[1]->answers->where('moderation_level',0) as $answer)
							<li class="list-group-item">
								<!-- upvote -->
								<div class="buttons pull-right">
									<a>
										<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
									</a>
								</div>
								<b>
									@unless($answer->anonymous)
										{{$answer->user_id}}
										@else
											Anoniem
											@endunless
											<small> at {{$answer->created_at}}</small>
								</b> <p>{{$answer->text}}</p>
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
							<div class="input-group-addon">
								Anoniem
								<input type="hidden" name="anonymous" value=0>
								<input type="checkbox" name="anonymous" value=1>
							</div>
							<input name="text" type="text" class="form-control" placeholder="Uw antwoord">
							<span class="input-group-btn">
								 <input type="submit" class="btn btn-default" value="Antw.">
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
					<h4 class="panel-title">Eli Boeye
						<small>{{$post[1]->created_at}}</small>
					</h4>
				</div>
				<div class="panel-body messageBody">
					<p>{{$post[1]->question}}</p>
				</div>

				<!-- verschillende antwoorden -->
				<div class="optionContainer row">
					<?php
					$total = 0;
					foreach ($post[1]->choices/*->where('moderation_level',0)*/ as $choice)
					{
						$total += $choice->count;
					}
					?>
					@forelse($post[1]->choices as $choice)

						<div class="options col-md-12">
							<div class="col-md-4 col-sm-4">
								<!-- OK button -->
								<button type="button" class="btn btn-default vote">
									<span class="glyphicon glyphicon-ok" area-hidden="true"></span>
								</button>

								<span class="progress-opt">{{$post[1]->text}}</span>
							</div>

							<div class="col-md-6 col-sm-6">
								<div class="progress">
									<?php
									if ( $total != 0 )
									{
										$percentage = $choice->count / $total * 100;
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
						<h3 class="text-center">Er zijn geen mogelijke opties ingesteld :(</h3>
					@endforelse
				</div>

				@if($post[1]->addable)
					<!-- antwoord toevoegen -->
				<form>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Uw antwoord">
								<span class="input-group-btn">
									 <button class="btn btn-default" type="button">
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

			<!-- Voorbeeld Form om nieuwe message aan te maken -->
		<div id="messageForm" class="message">
			<form method="POST" action="/message">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="panel panel-default">
					<div class="panel-heading">
						<!-- input group -->
						<div class="btn-group">
							<button type="button" class="btn btn-default messageButton">Bericht</button>
							<button type="button" class="btn btn-default pollButton">Poll</button>
						</div>
					</div>
					<div class="panel-body messageBody">
							<textarea class="form-control" name="text" id="" cols="30" rows="5"
									  placeholder="Plaats hier uw vraag"></textarea>
						<input type="hidden" name="anonymous" value=0>
						<input type="checkbox" name="anonymous" value=1> Anoniem

						<div class="buttons pull-right submitButton" role="group">
							<input type="submit" class="btn btn-default">
						</div>
					</div>
				</div>

				<input type="hidden" name="user_id" value="{{1}}">
				<input type="hidden" name="wall_id" value="{{$wall->id}}">
				<input type="hidden" name="channel_id" value="{{1}}">
			</form>

		</div>

		<!-- Form om nieuwe poll aan te maken -->
		<div id="pollForm" class="message">
			<form action="">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="btn-group">
							<button type="button" class="btn btn-default messageButton">Bericht</button>
							<button type="button" class="btn btn-default pollButton">Poll</button>
						</div>
					</div>
					<div class="panel-body messageBody">
						<p>Waarom zijn de bananen krom</p>

						<ul class="list-group">
							<li class="list-group-item">
								Cras justo odio
								<a><span class="glyphicon glyphicon-remove pull-right"></span></a>
							</li>
							<li class="list-group-item">
								Dapibus ac facilisis in
								<a><span class="glyphicon glyphicon-remove pull-right"></span></a>
							</li>
			<textarea class="form-control" name="" id="" cols="30" rows="5"
					  placeholder="Plaats hier uw optie"></textarea>
							<input type="checkbox" name="anonymous" value="anonymous"> Anoniem
							<div class="buttons pull-right submitButton" role="group">
								<input type="submit" class="btn btn-default">
							</div>
						</ul>
					</div>
				</div>
			</form>
		</div>


	</div>
@stop

@section('footer')
	<script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
@stop
