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

		<header>

			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
				<a class="navbar-brand" href="#">SGPS</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
				        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active"><a class="nav-link" href="#">Dashboards</a></li>
						<li class="nav-item @if(Route::is('dashboard')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['dashboard'])}}">Meu Painel</a></li>
						<li class="nav-item @if(Route::is('cases.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['cases_index'])}}">Casos</a></li>
						<li class="nav-item @if(Route::is('alerts.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['alerts_index'])}}">Alertas</a></li>
						<li class="nav-item @if(Route::is('pendencies.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['pendencies_index'])}}">Pendências</a></li>
						<li class="nav-item @if(Route::is('reports.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['reports_index'])}}">Relatórios</a></li>
						<li class="nav-item @if(Route::is('admin.*')) active @endif"><a class="nav-link" href="{{route('wireframe.view', ['admin_index'])}}">Administração</a></li>
					</ul>
				</div>
			</nav>
		</header>

		<main role="main" class="container" style="margin-top: 55px;">
			@yield('main')
		</main>

		<script src="/js/app.js"></script>

	</body>
</html>
