@foreach($posts as $post)

@if($post[0]=='m')
@if(empty($post[1]->question_id))
	<!-- message -->
<div class="row message">
	<div class="panel panel-default">
		<div class="panel-heading">
			<!-- upvote -->
			<div class="buttons pull-right">
				@unless($post[1]->user()->first()->id==Auth::user()->id)
					<form method="POST" action="/votemessage">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="message_id" value="{{$post[1]->id}}">
						<input type="hidden" name="user_id" value="{{Auth::user()->id}}">

						@if(Auth::user()->messageVotes()->where('message_id',$post[1]->id)->first())
							<button class="active" type="submit">
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
							</button>
						@else
							<button class="" type="submit">
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
							</button>
						@endif
					</form>
				@endunless
				{{"upvotes: ".$post[1]->count}}
			</div>



			<h4 class="panel-title">
				@unless($post[1]->anonymous)
					{{$post[1]->user()->first()->name}}
					@else
						Anoniem
						@endunless
						<small>
							{{
								\App\Http\Controllers\WallController::humanTimeDifference($post[1]->created_at)
							}}
						</small>
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
							@unless($post[1]->user()->first()->id==Auth::user()->id)
								<form>
									<input type="hidden" name="message_id" value={{$post[1]->id}}>
									<!-- ID of the OP -->
									<input type="hidden" name="user_id" value={{$post[1]->user()->id}}>

									@unless(Auth::user()->id==$post[1]->user()->id)
										<button type="submit" class="form-control upvote active">
											<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
										</button>
									@endunless
								</form>
							@endunless
						</div>

						@unless($answer->anonymous)
							{{$answer->user->name}}
							@else
								Anoniem
								@endunless
								<small>
									{{
										\App\Http\Controllers\WallController::humanTimeDifference($answer->created_at)
									}}
								</small>
								<p class="answer">{{$answer->text}}</p>
					</li>
				@endforeach
			</ul>
			@endunless

			@unless(Auth::user()->banned())
			<!-- antwoord toevoegen -->
			<form method="POST" action="/message">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="question_id" value="{{$post[1]->id}}">
				<input type="hidden" name="channel_id" value="{{1}}">
				<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
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
			@endunless
	</div>
</div>
@endif
@elseif($post[0]=='p')
	<!-- poll -->
<div class="row message poll">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">{{$post[1]->user()->first()->name}}
				<small>{{
						\App\Http\Controllers\WallController::humanTimeDifference($post[1]->created_at)
						}}</small>
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
							<input type="hidden" name="user_id" value={{Auth::user()->id}}>

							@if(Auth::user()->pollVotes()->where('poll_choice_id',$choice->id)->first())
								<button type="submit" class="btn btn-default vote active">
									<span class="glyphicon glyphicon-ok" area-hidden="true"></span>
								</button>
							@else
								<button type="submit" class="btn btn-default vote">
									<span class="glyphicon glyphicon-ok" area-hidden="true"></span>
								</button>
							@endif

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

		@if($post[1]->addable && !Auth::user()->banned())
			<!-- antwoord toevoegen -->
		<form method="POST" action="{{ action("PollChoiceController@store") }}">
			<div class="input-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="user_id" value={{1}}>
				<input type="hidden" name="poll_id" value={{$post[1]->id}}>
				<input type="text" name="text" class="form-control" placeholder="Uw optie">
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