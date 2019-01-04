<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=page-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Sistema de Gestão de Projetos Sociais - Prefeitura do Rio de Janeiro">
		<meta name="author" content="LQDI">

		<title>Imprimir - SGPS</title>

		<link href="/css/app.css?v={{config('frontend.assets_version', 'NV')}}" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	</head>

	<body>
		<div id="print">
			<div class="container-fluid">
				@yield('body')
			</div>
		</div>

	</body>
</html>
