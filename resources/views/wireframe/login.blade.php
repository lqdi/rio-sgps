@extends('base_html')
@section('body')
	<form class="login__form text-center" action="{{route('wireframe.view', ['cases_index'])}}">
		<img class="mb-4" src="{{asset('images/logo-w200.png')}}" alt="SGPS">

		<h1 class="h3 mb-3 font-weight-normal">Acessar o sistema</h1>

		<label for="fld-email" class="sr-only">E-mail</label>
		<input type="email" id="fld-email" class="form-control" placeholder="E-mail ..." autofocus />

		<label for="fld-password" class="sr-only">Senha</label>
		<input type="password" id="fld-password" class="form-control" placeholder="Senha ..." />

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Manter-se conectado
			</label>
		</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Acessar <i class="fa fa-arrow-right"></i></button>

	</form>
@endsection