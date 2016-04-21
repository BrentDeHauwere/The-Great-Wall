<html>
	<head>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="messagewall.css">
	</head>
	<body>

		<div class="messagesContainer center-block">
			<h3>Messagewall ¯\_(ツ)_/¯</h3>

			<!-- een bunch messages -->
			@for($i=0;$i<1;$i++)

				<!-- Voorbeeld message -->
			<div class="message">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="buttons pull-right" role="group">
							<!-- upvote -->
							<a class="">
								<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
							</a>
						</div>
						<h4>Eli Boeye
							<small>13:37</small>
						</h4>
					</div>
					<div class="panel-body messageBody">
						Dit is de diepste vraag ter wereld?
					</div>
					<!-- verschillende antwoorden -->
					<ul class="list-group">
						<li class="list-group-item">
							<b>Arnaud niet koel
								<small> 14:20</small>
							</b> - Ik ben het daar niet mee eens
						</li>
						<li class="list-group-item">
							<b>Bront
								<small> 14:40</small>
							</b> - Ikke wel
						</li>
					</ul>
					<!-- antwoord toevoegen -->
					<form>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Uw antwoord">
                        <span class="input-group-btn">
                             <button class="btn btn-default" type="button">
								 Antw.
							 </button>
                         </span>
						</div>
					</form>
				</div>
			</div>

			<!-- Voorbeeld poll -->
			<div class="message">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Eli Boeye
							<small>13:37</small>
						</h4>
					</div>
					<div class="panel-body messageBody">
						Dit is de diepste vraag ter wereld?
					</div>

					<!-- verschillende antwoorden -->
					<div class="container options">
						<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 poll">

							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-3">
									<span class="progress-opt">Patat</span>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-7">
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
											60%
										</div>
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-1">
									<span class="progress-votes">60</span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-3">
									<span class="progress-opt">Wortel</span>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-7">
									<div class="progress">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
											30%
										</div>
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-1">
									<span class="progress-votes">30</span>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-3">
									<span class="progress-opt">Tomaat</span>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-7">
									<div class="progress">
										<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100" style="width: 16%;">
											8%
										</div>
									</div>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-1">
									<span class="progress-votes">8</span>
								</div>
							</div>

						</div>
					</div>

					<!-- antwoord toevoegen -->
					<form>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Uw antwoord">
                        <span class="input-group-btn">
                             <button class="btn btn-default" type="button">
								 Antw.
							 </button>
                         </span>
						</div>
					</form>
				</div>
			</div>
			@endfor


		</div>
	</body>
</html>