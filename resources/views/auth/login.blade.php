@extends('shared.base_html')
@section('body')

	<div class="login__form text-center">

		<img class="mb-4" src="{{asset('images/sgps-w350.png')}}" alt="SGPS">

		<h1 class="h3 mb-3 font-weight-normal">Acessar o sistema</h1>

		<ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="pill" href="#login-with-cerberus" role="tab" aria-controls="pills-home"><i class="fa fa-globe"></i> CERBERUS</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="pill" href="#login-with-sgps" role="tab" aria-controls="pills-profile"><i class="fa fa-cog"></i> SGPS</a>
			</li>
		</ul>
		<div class="panel">
			<div class="panel-content bg-light p-3">

				@include('components.messages')

				<div class="tab-content">
					<div class="tab-pane fade show active" id="login-with-cerberus" role="tabpanel">


						<div class="mb-3">
							<small class="text-secondary">Entre com seu RioMail, CPF ou matrícula.</small>
						</div>

						<form method="POST" action="{{route('auth.login.with_cerberus')}}">
							@csrf

							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-globe"></i></span>
								</div>
								<input type="text" name="login" class="form-control" placeholder="Login..." required autofocus>
							</div>

							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-key"></i></span>
								</div>
								<input type="password" name="password" class="form-control" placeholder="Senha..." required >
							</div>

							<div class="checkbox mb-3">
								<label>
									<input type="checkbox" name="remember" value="yes"> Manter-se conectado
								</label>
							</div>

							<button class="btn btn-lg btn-primary btn-block" type="submit">Acessar <i class="fa fa-arrow-right"></i></button>

						</form>

					</div>
					<div class="tab-pane fade" id="login-with-sgps" role="tabpanel">

						<div class="mb-3">
							<small class="text-secondary">Entre com seu e-mail e senha do sistema SGPS.</small>
						</div>


						<form method="POST" action="{{route('auth.login')}}">
							@csrf

							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-envelope"></i></span>
								</div>
								<input type="email" name="email" class="form-control" placeholder="E-mail..." required autofocus>
							</div>

							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-key"></i></span>
								</div>
								<input type="password" name="password" class="form-control" placeholder="Senha..." required>
							</div>

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
		</div>


	</div>
@endsection