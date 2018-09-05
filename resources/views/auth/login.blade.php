@extends('shared.base_html')
@section('body')
	<form method="POST" class="login__form text-center" action="{{route('auth.login')}}">
		@csrf

		<img class="mb-4" src="{{asset('images/logo-w200.png')}}" alt="SGPS">

		<h1 class="h3 mb-3 font-weight-normal">Acessar o sistema</h1>

		<label for="fld-email" class="sr-only">E-mail</label>
		<input required type="email" name="email" id="fld-email" class="form-control" placeholder="E-mail ..." autofocus />

		<label for="fld-password" class="sr-only">Senha</label>
		<input required type="password" name="password" id="fld-password" class="form-control" placeholder="Senha ..." />

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" name="remember" value="yes"> Manter-se conectado
			</label>
		</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Acessar <i class="fa fa-arrow-right"></i></button>

	</form>
@endsection