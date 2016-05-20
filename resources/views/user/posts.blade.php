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
		<div class="ui cards four stackable" id="holder">
			@foreach($messages as $message)
				<div class="card">
					<div class="content">
						@if ($message->channel_id == 1)
							<i class="desktop icon blue right floated ui image"></i>
						@elseif ($message->channel_id == 2)
							<i class="icon twitter blue right floated ui image"></i>
						@endif
						<div class="header">
							{{ $message->wall->name }}
						</div>
						<div class="meta">
							{{ App\Http\Controllers\WallController::humanTimeDifference($message->created_at) }}
							,
							{{$message->count}} upvotes
						</div>
						<div class="description">
							{{ $message->text }}
						</div>
					</div>
				</div>
			@endforeach
			@foreach($polls as $poll)
				<div class="card">
					<div class="content">
						<i class="desktop icon blue right floated ui image"></i>
						<div class="header">
							{{ $poll->wall->name }}
						</div>
						<div class="meta">
							{{ App\Http\Controllers\WallController::humanTimeDifference($message->created_at) }}
						</div>
						<div class="description">
							{{ $poll->question }}
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@stop