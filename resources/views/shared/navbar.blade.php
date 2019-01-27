<header>

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#"><strong>SGPS</strong> / TS</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
			        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item @if(Route::is('dashboard.*')) active @endif"><a class="nav-link" href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> Meu Painel</a></li>
					<li class="nav-item @if(Route::is('families.*')) active @endif"><a class="nav-link" href="{{route('families.index')}}"><i class="fa fa-male"></i> Famílias</a></li>
					<li class="nav-item @if(Route::is('alerts.*')) active @endif"><a class="nav-link" href="{{route('alerts.index')}}"><i class="fa fa-exclamation-triangle"></i> Alertas</a></li>
					@if(auth()->user()->hasLevel(\SGPS\Constants\UserLevel::ADMIN))<li class="nav-item @if(Route::is('admin.*')) active @endif"><a class="nav-link" href="{{route('admin.dashboard.index')}}"><i class="fa fa-cog"></i> Administração</a></li>@endif
					<li class="nav-item nav-logout">
						<form method="POST" action="{{route('auth.logout')}}">
							@csrf
							<button type="submit" class="nav-link"><i class="fa fa-sign-out-alt"></i> Sair</button>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>