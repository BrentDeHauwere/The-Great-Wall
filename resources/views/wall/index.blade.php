@extends('masterlayout')

@section('title', 'Walls')

@section('page','home')

@section('content')
	<div class="ui divided items" id="walls">

		@foreach ($walls as $wall)
			<div class="item">
				<div class="image">
					<img src="http://semantic-ui.com/images/wireframe/image.png">
				</div>
				<div class="content">
					<a class="header">{{ $wall->name }}</a>
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
									<input type="password" placeholder="Password" name="password" required>
									<button type="submit" class="ui blue right labeled icon button">
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
					</div>
				</div>
			</div>
		@endforeach
	</div>
@stop
