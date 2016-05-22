<!DOCTYPE html>
<html>
	<head>
		<title>404 - Not Found</title>

		<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
		<script src="{{ asset('js/jquery.rotate.js') }}"></script>

		<style>
			html, body
			{
				height: 100%;
			}

			body
			{
				margin: 0;
				padding: 0;
				width: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container
			{
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content
			{
				text-align: center;
				display: inline-block;
			}

			.title
			{
				font-size: 72px;
				margin-bottom: 40px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">404 - Not Found</div>
				<img id="arco" src="{{ asset('img/arco.png') }}" style="width: 25%; height: 25%;" />

				<marquee class="title" scrolldelay="100" behaviour="alternate" direction="down">
					Geen paniek, ik ben studentenvertegenwoordiger!
				</marquee>
			</div>
		</div>
		<audio autoplay loop>
			<source src="{{asset("music/mjoezik.mp3")}}" type="audio/mpeg">
		</audio>
	</body>

	<script>
		$("#arco").mouseover(function() {
			$(this).rotate({
				angle: 0,
				animateTo: 360
			});
		});
	</script>
</html>