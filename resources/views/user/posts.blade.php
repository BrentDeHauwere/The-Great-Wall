@extends('masterlayout')

@section('title', 'My Posts')

@section('content')
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
		@if($messages->isEmpty() && $polls->isEmpty())
			<div class="ui center aligned segment meta">
				You have no posts yet... What are you waiting for?
			</div>
		@endif
		<div class="ui cards four stackable" id="holder">
			@foreach($messages as $message)
				<div class="card">
					<div class="content">
						@if ($message->channel_id == 1)
							<i class="home icon blue right floated ui image"></i>
						@elseif ($message->channel_id == 2)
							<i class="icon twitter blue right floated ui image"></i>
						@endif
						<div class="header">
							{{ $message->wall->name }}
						</div>
						<div class="meta">
							{{ App\Http\Controllers\WallController::humanTimeDifference($message->created_at) }}
							,
							{{$message->count}} favourites
						</div>
						<div class="description">
							{{ $message->text }}
						</div>
					</div>
					@if($message->moderation_level == 1)
					<div class="extra content">
						<div class="meta">This message was blocked.</div>
					</div>
					@endif
				</div>
			@endforeach
			@foreach($polls as $poll)
				<div class="card">
					<div class="content">
						<i class="home icon blue right floated ui image"></i>
						<div class="header">
							{{ $poll->wall->name }}
						</div>
						<div class="meta">
							{{ App\Http\Controllers\WallController::humanTimeDifference($poll->created_at) }}
						</div>
						<div class="description">
							{{ $poll->question }}
						</div>
					</div>
					@if($poll->moderation_level == 1)
						<div class="extra content">
							<div class="meta">This poll was blocked.</div>
						</div>
					@endif
				</div>
			@endforeach
		</div>
	</div>
@stop