<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>SGPS</title>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
		<link href="/css/app.css" rel="stylesheet">

	</head>

	<body>
		<div id="app">
			<header>

				<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
					<div class="container">
						<a class="navbar-brand" href="#">SGPS</a>

						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
						        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarCollapse">
							<ul class="navbar-nav mr-auto">
								<li class="nav-item @if(Route::is('dashboard.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['dashboard'])}}"><i class="fa fa-tachometer-alt"></i> Meu Painel</a></li>
								<li class="nav-item @if(Route::is('cases.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['cases_index'])}}"><i class="fa fa-list"></i> Casos</a></li>
								<li class="nav-item @if(Route::is('alerts.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['alerts_index'])}}"><i class="fa fa-exclamation-triangle"></i> Alertas</a></li>
								<li class="nav-item @if(Route::is('pendencies.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['pendencies_index'])}}"><i class="fa fa-check-square"></i> Pendências</a></li>
								<li class="nav-item @if(Route::is('reports.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['reports_index'])}}"><i class="fa fa-chart-bar"></i> Relatórios</a></li>
								<li class="nav-item @if(Route::is('admin.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['admin_index'])}}"><i class="fa fa-cog"></i> Administração</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</header>

			<main role="main" style="margin-top: 55px;">
				@yield('main')
			</main>
		</div>

		<script src="/js/app.js"></script>

	</body>
</html>
