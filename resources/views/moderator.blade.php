<html>
	<head>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"  rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">

				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>

		<!-- Moderator Stuff Now -->
		<div class="container">
			<div class="col-md-12">
				<div class="list-group">
					@foreach($result as $row)
						@if($row['moderation_level'] == "M")
							@if($row['moderation_level'] == 1)
								<div class="list-group-item list-group-item-danger">
							@elseif($row['moderation_level'] == 0)
								<div class="list-group-item list-group-item-success">
							@else
								<div class="list-group-item list-group-item-blocked">
							@endif
							<div class="pull-right">
								<form class="btn-group" method="POST" action="/messagewall/moderator/message/accept">
									<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="/messagewall/moderator/message/decline">
									<input type="hidden" class="btn">
									<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="">
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<button type="submit" class="btn greybtn"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></button>
								</form>
							</div>
							<h4 class="list-group-item-heading">User {{ $row['M'].' '.$row['created_at'] }}</h4>
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
								<form class="btn-group" method="POST" action="/messagewall/moderator/poll/accept">
									<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="/messagewall/moderator/poll/decline">
									<input type="hidden" class="btn">
									<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
									<input type="hidden" class="btn">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="message_id" value="{{ $row['id'] }}"/>
								</form>
								<form class="btn-group" method="POST" action="">
									<input type="hidden" class="btn">
									<input type="hidden" class="btn">
									<button type="submit" class="btn greybtn"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></button>
								</form>
							</div>
							<h4 class="list-group-item-heading">User {{ $row['M'].' '.$row['created_at'] }}</h4>
							<p class="list-group-item-text">
								{{ $row['content'] }}
							</p>
						@endif
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</body>
</html>



