@extends("masterlayout")
@section('header')
	<link rel="stylesheet" type="text/css" href="/css/messagewall.css">
@stop

@section('title', 'The Great Wall')

@section('content')

	<div class=" container messagesContainer center-block">
		<h3>{{$wallName}}</h3>

		@forelse($posts as $post)

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
							<h4>
								@unless($post[1]->anonymous)
									{{$post[1]->user_id}}
									@else
										Anoniem
										@endunless
										<small>{{$post[1]->created_at}}</small>
							</h4>
						</div>
						<div class="panel-body messageBody">
							{{$post[1]->text}}
						</div>

						<!-- antwoorden -->
						@unless($post[1]->answers->isEmpty())
							<ul class="list-group">
								@foreach($post[1]->answers->where('moderation_level',0) as $answer)
									<li class="list-group-item">
										<b>
											@unless($answer->anonymous)
												{{$answer->user_id}}
												@else
													Anoniem
													@endunless
													<small> {{$answer->created_at}}</small>
										</b> {{$answer->text}}
											<!-- upvote -->
										<div class="buttons pull-right">

											<a class="">
												<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						@endunless


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

			@elseif($post[0]=='p')
				<!-- poll -->
				<div class="row message poll">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Eli Boeye
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

		@empty
			<h3>Er is nog geen bericht geplaatst op deze wall</h3>
		@endforelse





			<h1>TEST FORMS</h1>
			<!-- input group -->
			<div class="btn-group">
				<button id="messageButton" type="button" class="btn btn-default">Bericht</button>
				<button id="pollButton" type="button" class="btn btn-default">Poll</button>
			</div>

			<!-- Voorbeeld Form om nieuwe message aan te maken -->
			<div id="messageForm" class="message">
				<form>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Eli Boeye</h4>
						</div>
						<div class="panel-body messageBody">

			<textarea class="form-control" name="" id="" cols="30" rows="5"
					  placeholder="Plaats hier uw vraag"></textarea>
							<input type="checkbox" name="anonymous" value="anonymous"> Anoniem
							<div class="buttons pull-right submitButton" role="group">
								<input type="submit" class="btn btn-default">
							</div>
						</div>
					</div>
				</form>

			</div>

			<!-- Form om nieuwe poll aan te maken -->
			<div id="pollForm" class="message">
				<form action="">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Eli Boeye</h4>
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-2.2.3.min.js"
			integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
	<script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
@stop