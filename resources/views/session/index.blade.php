@extends('masterlayout')

@section('title', 'Walls')

@section('page','moderate')

@section('content')
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<div class="body_customized">
		<table class="ui celled table">
			<thead class="full-width">
				<tr>
					<th colspan="6">
						<a class="ui right floated small primary labeled icon button" href="{{ action('SessionController@create') }}">
							<i class="plus icon"></i> Add Session
						</a>
						<a class="ui right labeled icon button small" href="{{ action('BlacklistController@index') }}">
							<i class="right chevron icon"></i>
							Go to Blacklist
						</a>
					</th>
				</tr>
				<tr>
					<th>ID</th>
					<th>User ID</th>
					<th>Name</th>
					<th>Protected</th>
					<th>Open until</th>
					<th style="width: 319px">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($walls as $key => $value)
					<tr>
						<td>{{ $value->id }}</td>
						<td>{{ $value->user_id }}</td>
						<td>{{ $value->name }}</td>
						<td>{{ $value->password }}</td>
						@if ($value->open_until == 'Infinity (not set)')
							<td class="error"><i class="attention icon"></i> {{$value->open_until}}</td>
						@else
							<td>{{ $value->open_until }}</td>
						@endif
						<td>
							<a class="ui basic button" href="{{ action('SessionController@show', $value->id) }}">
								<i class="icon dashboard"></i>
								Show
							</a>
							<a class="ui basic button" href="{{ action('SessionController@edit', $value->id) }}">
								<i class="icon edit"></i>
								Edit
							</a>
							<form action="{{action('SessionController@destroy', $value->id)}}" method="post" class="form_inline_customize">
								<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
								<input type="hidden" name="_method" value="delete"/>
								<button class="ui basic red button" type="submit" style="margin-right: 0px">
									<i class="icon hide"></i>
									Close
								</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection
