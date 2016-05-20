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
			@foreach($posts as $post)
					<div class="card">
						<div class="content">
							<p>{{ $post->text }}</p>
						</div>
						<div class="extra content">

						</div>
					</div>
			@endforeach
		</div>
	</div>
@stop