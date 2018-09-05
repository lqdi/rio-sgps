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
					<li class="nav-item @if(Route::is('dashboard.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-tachometer-alt"></i> Meu Painel</a></li>
					<li class="nav-item @if(Route::is('cases.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-list"></i> Casos</a></li>
					<li class="nav-item @if(Route::is('alerts.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-exclamation-triangle"></i> Alertas</a></li>
					<li class="nav-item @if(Route::is('pendencies.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-check-square"></i> Pendências</a></li>
					<li class="nav-item @if(Route::is('reports.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-chart-bar"></i> Relatórios</a></li>
					<li class="nav-item @if(Route::is('admin.*')) active @endif"><a class="nav-link" href="#"><i class="fa fa-cog"></i> Administração</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>