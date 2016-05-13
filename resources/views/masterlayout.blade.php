<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="/favicon.ico">
		<title>The Great Wall - @yield('title')</title>
		<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
		<script src="{{asset('/js/smoothscroll.js')}}"></script>

		<!-- REMOVED
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/style.css"/>
		-->

		<!-- Semantic UI - CSS -->
		<link rel="stylesheet" type="text/css" href="/semantic/dist/semantic.min.css">
		<link rel="stylesheet" type="text/css" href="/css/customize_semantic.css">

		@yield('header')
		@yield('page-script')
		<script>
			$(document).ready(function ()
			{
				var page = "@yield('page')";
				$('.ui .item').removeClass('active');
				$("#" + page).addClass('active');
			});

			$('#user').blur(function ()
			{
				console.log('event fired');
				var page = "@yield('page')";
				$('.ui .item').removeClass('active');
				$("#" + page).addClass('active');
			});
		</script>
	</head>
	<body>
		<div class="ui inverted segment" id="navigation">
			<div class="ui inverted secondary pointing menu">
				@if(Auth::user()->role == 'Moderator')
					<a class="item" href="{{ action('WallController@index') }}" id="home">
						Home
					</a>
					<a class="item" href="{{ action('SessionController@index') }}" id="moderate">
						Moderate
					</a>
					<a class="item" href="{{ action('BlacklistController@index') }}" id="blacklist">
						Blacklist
					</a>
				@else
					<a class="item" href="{{ action('WallController@index') }}" id="home">
						The Great Wall &nbsp; <small>Home</small>
					</a>
				@endif
				<div class="right menu">
					<div class="ui dropdown item" id="user">
						{{ Auth::user()->name }} <i class="user icon icon_customized"></i>
						<div class="menu">
							<a class="item" href="{{ action('UserController@logout') }}">Logout</a>
							<a class="item">More</a>
							<a class="item">More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="navigation_margin">
		</div>

		@if(session()->has('success'))
			@success({{ session('success') }})
		@elseif(!empty($success))
			@success({{ $success }})
		@endif

		@if(session()->has('warning'))
			@warning({{ session('warning') }})
		@elseif(!empty($warning))
			@warning({{ $warning }})
		@endif

		@if(session()->has('error'))
			@error({{ session('error') }})
		@elseif(!empty($error))
			@error({{ $error }})
		@endif

		@if(session()->has('info'))
			@info({{ session('info') }})
		@elseif(!empty($info))
			@info({{ $info }})
		@endif

		<script>
			$('.message .close')
				.on('click', function() {
					$(this)
						.closest('.message')
						.transition('fade')
					;
				})
			;
		</script>

		@yield('content')

		<div id="footer_margin">
		</div>
		<!--<footer>
			<p>Made by Brent De Hauwere, Eli Boey, Jonas De Pelsmaeker and Kamiel Klumpers</p>
		</footer>-->
		@yield('footer')

			<!-- Semantic UI - JS -->
		<script src="/semantic/dist/semantic.min.js"></script>
		<script src="/js/customize_semantic.js"></script>
	</body>
</html>
