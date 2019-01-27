@extends('shared.base_html')
@section('body')

	<div class="login__form text-center">

		<img class="mb-4" src="{{asset('images/logo-w200.png')}}" alt="SGPS">

		<h1 class="h3 mb-3 font-weight-normal">Acessar o sistema</h1>

		<ul class="nav nav-tabs mb-3" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="pill" href="#login-with-cerberus" role="tab" aria-controls="pills-home">CERBERUS</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="pill" href="#login-with-sgps" role="tab" aria-controls="pills-profile">SGPS</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="login-with-cerberus" role="tabpanel">

				<form method="POST" action="{{route('auth.login.with_cerberus')}}">
					@csrf

					<label for="fld-cerberus-email" class="sr-only">E-mail</label>
					<input required type="text" name="login" id="fld-cerberus-email" class="form-control" placeholder="Login ..." autofocus />

					<label for="fld-cerberus-password" class="sr-only">Senha</label>
					<input required type="password" name="password" id="fld-cerberus-password" class="form-control" placeholder="Senha ..." />

					<div class="checkbox mb-3">
						<label>
							<input type="checkbox" name="remember" value="yes"> Manter-se conectado
						</label>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit">Acessar <i class="fa fa-arrow-right"></i></button>

				</form>

			</div>
			<div class="tab-pane fade" id="login-with-sgps" role="tabpanel">

				<form method="POST" action="{{route('auth.login')}}">
					@csrf

					<label for="fld-sgps-email" class="sr-only">E-mail</label>
					<input required type="email" name="email" id="fld-sgps-email" class="form-control" placeholder="E-mail ..." autofocus />

					<label for="fld-sgps-password" class="sr-only">Senha</label>
					<input required type="password" name="password" id="fld-sgps-password" class="form-control" placeholder="Senha ..." />

					<div class="checkbox mb-3">
						<label>
							<input type="checkbox" name="remember" value="yes"> Manter-se conectado
						</label>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit">Acessar <i class="fa fa-arrow-right"></i></button>

				</form>

			</div>
		</div>

	</div>
@endsection