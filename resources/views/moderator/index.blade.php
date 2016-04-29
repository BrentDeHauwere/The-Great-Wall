@extends('masterlayout')

@section('title', 'Moderator')

@section('content')


		<!-- Moderator Stuff Now -->
			<div class="col-md-12">
				<div class="list-group">
					@foreach($result as $row)
						@if($row['M'] == "M")
							@if($row['moderation_level'] == 1)
								<div class="list-group-item list-group-item-danger">
							@elseif($row['moderation_level'] == 0)
								<div class="list-group-item list-group-item-success">
							@else
								<div class="list-group-item list-group-item-blocked">
							@endif
							<div class="pull-right">
								<form class="btn-group" method="POST" action="/message/accept">
									<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="/message/decline">
									<input type="hidden" class="btn">
									<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="GET" action="{{action('BlacklistController@create')}}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}">
									<button type="submit" class="btn greybtn"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></button>
								</form>
							</div>
							<h4 class="list-group-item-heading">User <!-- Ophalen van CAPI--></h4>
							<p class="list-group-item-text">
								{{ $row['text'] }}
							</p>
						@elseif($row['M'] == "P")
							@if($row['moderation_level'] == 1)
								<div class="list-group-item list-group-item-danger">
							@elseif($row['moderation_level'] == 0)
								<div class="list-group-item list-group-item-success">
							@else
								<div class="list-group-item list-group-item-blocked">
							@endif
							<div class="pull-right">
								<form class="btn-group" method="POST" action="/TheGreatWall/moderator/poll/accept">
									<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="/TheGreatWall/moderator/poll/decline">
									<input type="hidden" class="btn">
									<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="GET" action="/TheGreatWall/blacklist/create">
									<input type="hidden" name="poll_id" value="{{ $row['id'] }}">
									<button type="submit" class="btn greybtn"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></button>
								</form>
							</div>
							<h4 class="list-group-item-heading">User  <!-- Ophalen van CAPI--></h4>
							<p class="list-group-item-text">
								{{ $row['text'] }}
							</p>
						@endif
					</div>
					@endforeach
				</div>
			</div>
@stop
