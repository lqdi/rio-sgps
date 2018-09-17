<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Sistema de Gestão de Projetos Sociais - Prefeitura do Rio de Janeiro">
		<meta name="author" content="LQDI">

		<meta name="csrf-token" content="{{csrf_token()}}" />

		<title>SGPS</title>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
		<link href="/css/app.css" rel="stylesheet">

		<script>
			window.SGPS_API_URL = '{{str_finish(config('frontend.api_url'), '/')}}';

			@auth
				window.SGPS_TOKEN = '{{auth()->user()->toJWT()}}';
				window.SGPS_USER_ID = '{{auth()->id()}}';
			@endauth
		</script>

	</head>

	<body>
		<div id="app">
			@yield('body')
		</div>

		<script src="/js/app.js"></script>

	</body>
</html>
