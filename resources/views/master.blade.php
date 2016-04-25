<html>
	<head>
		<title>The Great Wall - @yield('title')</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		@section('header')
	</head>
	<body>
		@section('sidebar')

		<div class="container">
			@yield('content')
		</div>
	</body>
</html>