@extends('masterlayout')

@section('title', 'Walls')

@section('page','home')

@section('content')
	@if (empty(Auth::user()->twitter_handle))
		@info(Did you know that you can post messages via Twitter? What are you waiting for? Fill in your <a href="#" onclick="$( '#setTwitterHandle' ).trigger( 'click' );">Twitter handle</a>!)
	@endif

	<div class="body_customized" style="height: 51px">
		<div class="ui icon input search medium">
			<input type="text" placeholder="Search..." id="search_input">
			<i class="search icon"></i>
		</div>
	</div>

	<div class="body_customized">
		<div class="ui divided items" id="walls">
			@foreach ($walls as $wall)
				<div class="item">
					<div class="image">
						<img src="{{ route('wall_images', ['filename' => $wall->id]) }}">
					</div>
					<div class="content">
						<h1 class="header">{{ $wall->name }}</h1>
						@if(!empty($wall->hashtag))
							<i class="icon twitter blue"></i>
							{{ '#' . $wall->hashtag }}
						@endif
						<div class="meta">
							<span class="cinema">{{ $wall->username }}</span>
						</div>
						<div class="description black">
							<p>{{ $wall->description }}</p>
						</div>
						<div class="extra">
							@if (!empty($wall->password))
								<form action="{{ action('WallController@enterWallWithPassword') }}" method="post">
									<div class="ui action input right floated">
										{{ csrf_field() }}
										<input type="hidden" name="wall_id" value="{{$wall->id}}">
										<input type="password" placeholder="Password" name="password" class="passwordField" required>
										<button type="submit" class="ui blue right labeled icon button passwordButton">
											<i class="lock icon"></i>
											Enter
										</button>
									</div>
								</form>
							@else
								<div class="ui action right floated">
									<button type="button" class="ui blue floated right labeled icon button" onclick="location.href='{{ action('WallController@show', ['wall_id' => $wall->id]) }}';">
										<i class="right chevron icon"></i>
										Enter
									</button>
								</div>
							@endif
							<div class="ui tag labels">
								@foreach ($wall->tags as $tag)
									@if ($tag != null)
										<a class="ui label">
											{{ $tag }}
										</a>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<script src="/js/jquery.tablesort.js"></script>
	<script>
		$('.items').tablesort();

		var $rows = $('.items .item');
		$('#search_input').keyup(function ()
		{
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

			$rows.show().filter(function ()
			{
				var text = $(this).find('.header').text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
	</script>

	<script>
		$(".passwordField").hide();

		$(".passwordButton").mouseover(function() {
			$(this).prev().fadeIn(500);
		});
	</script>
@stop
