@extends("masterlayout")
@section('header')
	<link rel="stylesheet" type="text/css" href="/css/messagewall.css">
@stop

@section('title', 'The Great Wall')

@section('content')

	<div class=" container messagesContainer center-block">
		<h3>INSERT TITLE HERE ¯\_(ツ)_/¯</h3>

		@forelse($messages as $message)
		@if(empty($message->question_id))
			<!-- Voorbeeld message -->
		<div class="row message">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="buttons pull-right" role="group">
						<!-- upvote -->
						<a class="">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</a>
					</div>
					<h4>
						@unless($message->anonymous)
							{{$message->user_id}}
							@else
								Anoniem
								@endunless
								<small>{{$message->created_at}}</small>
					</h4>
				</div>
				<div class="panel-body messageBody">
					{{$message->text}}
				</div>

				<!-- antwoorden -->
				<ul class="list-group">
					@foreach($message->answers as $answer)
						<li class="list-group-item">
							<b>
								@unless($answer->anonymous)
									{{$answer->user_id}}
									@else
										Anoniem
										@endunless
										<small> {{$answer->created_at}}</small>
							</b> {{$answer->text}}
						</li>
					@endforeach
				</ul>


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
			</div>
		</div>
		@endif

		@empty
			<h3>Er is nog geen bericht geplaatst op deze wall</h3>
			@endforelse


			@foreach($polls as $poll)

				<!-- Voorbeeld poll -->
			<div class="row message poll">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Eli Boeye
							<small>{{$poll->created_at}}</small>
						</h4>
					</div>
					<div class="panel-body messageBody">
						<p>{{$poll->question}}</p>
					</div>

					<!-- verschillende antwoorden -->
					<div class="optionContainer">
						@forelse($poll->choices as $choice)
							<div class="options col-md-12">
								<div class="col-md-4 col-sm-4">
									<!-- OK button -->
									<button type="button" class="btn btn-default vote">
										<span class="glyphicon glyphicon-ok" area-hidden="true"></span>
									</button>
									<span class="progress-opt">{{$choice->text}}</span>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
											 aria-valuemax="100" style="width: 60%;">
											60%
										</div>
									</div>
								</div>

								<div class="col-md-1 col-sm-1">
									<span class="progress-votes">60</span>
								</div>
							</div>
						@empty
							<h3 class="text-center">Er zijn geen mogelijk opties ingesteld :(</h3>
						@endforelse
					</div>

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

				</div>

			</div>
			@endforeach

			{{--<!-- input group -->--}}
			{{--<div class="btn-group">--}}
			{{--<button id="messageButton" type="button" class="btn btn-default">Bericht</button>--}}
			{{--<button id="pollButton" type="button" class="btn btn-default">Poll</button>--}}
			{{--</div>--}}

			{{--<!-- Voorbeeld Form om nieuwe message aan te maken -->--}}
			{{--<div id="messageForm" class="message">--}}
			{{--<form>--}}
			{{--<div class="panel panel-default">--}}
			{{--<div class="panel-heading">--}}
			{{--<h4>Eli Boeye</h4>--}}
			{{--</div>--}}
			{{--<div class="panel-body messageBody">--}}

			{{--<textarea class="form-control" name="" id="" cols="30" rows="5"--}}
			{{--placeholder="Plaats hier uw vraag"></textarea>--}}
			{{--<input type="checkbox" name="anonymous" value="anonymous"> Anoniem--}}
			{{--<div class="buttons pull-right submitButton" role="group">--}}
			{{--<input type="submit" class="btn btn-default">--}}
			{{--</div>--}}
			{{--</div>--}}
			{{--</div>--}}
			{{--</form>--}}

			{{--</div>--}}

			{{--<!-- Form om nieuwe poll aan te maken -->--}}
			{{--<div id="pollForm" class="message">--}}
			{{--<form action="">--}}
			{{--<div class="panel panel-default">--}}
			{{--<div class="panel-heading">--}}
			{{--<h4>Eli Boeye</h4>--}}
			{{--</div>--}}
			{{--<div class="panel-body messageBody">--}}
			{{--<p>Waarom zijn de bananen krom</p>--}}

			{{--<ul class="list-group">--}}
			{{--<li class="list-group-item">--}}
			{{--Cras justo odio--}}
			{{--<a><span class="glyphicon glyphicon-remove pull-right"></span></a>--}}
			{{--</li>--}}
			{{--<li class="list-group-item">--}}
			{{--Dapibus ac facilisis in--}}
			{{--<a><span class="glyphicon glyphicon-remove pull-right"></span></a>--}}
			{{--</li>--}}
			{{--<textarea class="form-control" name="" id="" cols="30" rows="5"--}}
			{{--placeholder="Plaats hier uw optie"></textarea>--}}
			{{--<input type="checkbox" name="anonymous" value="anonymous"> Anoniem--}}
			{{--<div class="buttons pull-right submitButton" role="group">--}}
			{{--<input type="submit" class="btn btn-default">--}}
			{{--</div>--}}
			{{--</ul>--}}
			{{--</div>--}}
			{{--</div>--}}
			{{--</form>--}}
			{{--</div>--}}


	</div>
@stop

@section('footer')
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-2.2.3.min.js"
			integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
	<script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
@stop