@extends('masterlayout')

@section('title', 'Sessions')

@section('page','moderate')

@section('content')
	<div class="body_customized">
		<table class="ui celled sortable table" id="table">

			<div class="ui icon input search medium">
				<input type="text" placeholder="Search..." id="search_input">
				<i class="search icon"></i>
			</div>
			<thead class="full-width">
				<tr>
					<th colspan="6" class="no-sort">
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
					<th>Speaker</th>
					<th>Name</th>
					<th>Protected</th>
					<th>Open until</th>
					<th class="no-sort" style="width: 332px">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($walls as $key => $value)
					<tr>
						<td>{{ $value->id }}</td>
						<td>{{ $value->user->name }}</td>
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
							@if ($value->open_until == 'Manually closed')
								<form action="{{action('SessionController@revertDestroy', $value->id)}}" method="post" class="form_inline_customize">
									<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
									<button class="ui basic green button" type="submit" style="margin-right: 0px">
										<i class="icon unhide"></i>
										Reopen
									</button>
								</form>
							@else
								<form action="{{action('SessionController@destroy', $value->id)}}" method="post" class="form_inline_customize">
									<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
									<input type="hidden" name="_method" value="delete"/>
									<button class="ui basic red button" type="submit" style="margin-right: 0px">
										<i class="icon hide"></i>
										Close
									</button>
								</form>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<script src="/js/jquery.tablesort.js"></script>
	<script>
		$('table').tablesort();

		var $rows = $('table tbody tr');
		$('#search_input').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
	</script>
@endsection
