@extends('masterlayout')

@section('title', 'Sessions')

@section('page','moderate')

@section('content')
	<form method="GET" action="{{ action('SessionController@showMultiple')}}">
	<div class="body_customized">
		<table class="ui celled sortable table" id="table">

			<div class="ui icon input search medium">
				<input type="text" placeholder="Search..." id="search_input">
				<i class="search icon"></i>
			</div>
			<thead class="full-width">
				<tr>
					<th colspan="7" class="no-sort">
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
					<th>Twitter</th>
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
						<td>{{ $value->hashtag }}</td>
						<td>{{ $value->password }}</td>
						@if ($value->open_until == 'Infinity (not set)')
							<td class="error"><i class="attention icon"></i> {{$value->open_until}}</td>
						@else
							<td>{{ $value->open_until }}</td>
						@endif
						<td>
							<div class="ui checkbox">
							  <input type="checkbox" name="beheer[]" value="{{ $value->id }}">
							  <label>Beheer deze wall</label>
							</div>
						</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="6"></td>
					<td>
						<button class="ui basic button" type="submit">
							<i class="icon dashboard"></i>
							Beheer meerdere walls
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	</form>
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
