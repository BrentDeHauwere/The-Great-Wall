@extends('masterlayout')

@section('title', 'Wall: ' . $wall->name)

@section('content')
	<div class="jumbotron text-center">
		<h2>{{ $wall->name }}</h2>
		<p>
			<strong>UserID:</strong> {{ $wall->user_id }}<br>
			<strong>Password:</strong> {{ $wall->password }}
		</p>
	</div>
@endsection
