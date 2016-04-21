<html>
	<head>
		<title>The Great Wall - @yield('title')</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		@section('header')
	</head>
	<body>
		@section('sidebar')

		<div class="container">
			@yield('content')
		</div>
	</body>
</html>