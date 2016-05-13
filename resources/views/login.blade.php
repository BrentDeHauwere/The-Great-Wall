<!DOCTYPE html>
<html>
	<head>
		<!-- Standard Meta -->
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- Site Properties -->
		<title>Login Example - Semantic</title>
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/reset.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/site.css">

		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/container.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/grid.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/header.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/image.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/menu.css">

		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/divider.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/segment.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/form.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/input.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/button.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/list.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/message.css">
		<link rel="stylesheet" type="text/css" href="/semantic/dist/components/icon.css">

		<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
		<script src="/semantic/dist/components/form.js"></script>
		<script src="/semantic/dist/components/transition.js"></script>

		<style type="text/css">
			body {
				background-color: #DADADA;
			}
			body > .grid {
				height: 100%;
			}
			.image {
				margin-top: -100px;
			}
			.column {
				max-width: 450px;
			}
		</style>
	</head>
	<body>

		<div class="ui middle aligned center aligned grid">
			<div class="column">
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
				<h2 class="ui blue image header">
					<img src="/img/icon_blue.png" class="image">
					<div class="content">
						Login to The Great Wall
					</div>
				</h2>
				<form class="ui large form" action="{{ action('UserController@login') }}" method="post">
					<div class="ui segment">
						<div class="field">
							<div class="ui left icon input">
								<i class="user icon"></i>
								<input type="text" name="email" placeholder="E-mail address">
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="lock icon"></i>
								<input type="password" name="password" placeholder="Password">
							</div>
						</div>
						<button class="ui fluid large blue submit button">Login</button>
					</div>
					{{ csrf_field() }}
					<div class="ui error message"></div>

				</form>

				<div class="ui message">
					New to us? <a href="http://ehackb.be/">Sign Up</a>
				</div>
			</div>
		</div>

		<script>
			$('.message .close').on('click', function() {
				console.log($(this).closest('.message'));
				$(this).closest('.message').fadeOut();;
			});
		</script>
	</body>

</html>