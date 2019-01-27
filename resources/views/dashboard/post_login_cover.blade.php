@extends('shared.base_html')
@section('body')

	<div class="post-login">

		<div class="p-3">
			<img class="mb-4" src="{{asset('images/sgps-w350.png')}}" alt="SGPS" style="max-width: 200px;">
		</div>


		<div class="container">


			<div class="panel bg-light p-3">
				<div class="panel-content">
					<div class="row">
						<div class="col-md-8">
							<h1><small>Bem vindo(a),</small><br />{{auth()->user()->getFirstName()}}</h1>
						</div>
						<div class="col-md-4">
							<dl>
								<dt><i class="fa fa-globe"></i> Autenticação:</dt>
								<dd><strong class="badge badge-success">{{trans('user.source.' . auth()->user()->source)}}</strong></dd>
								<dt><i class="fa fa-cog"></i> Tipo:</dt>
								<dd><strong class="badge badge-primary">{{trans('user.level.' . auth()->user()->level)}}</strong></dd>
								<dt><i class="fa fa-users"></i> Grupos:</dt>
								<dd>
									@if(sizeof(auth()->user()->groups) > 0)
										@foreach(auth()->user()->groups as $group) <span class="badge badge-secondary">{{$group->name}}</span> @endforeach
									@else
										<span class="badge badge-light">Nenhum</span>
									@endif
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>

			<br />

			<div class="panel bg-light p-3">
				<div class="panel-content">
					<h3>Escolha um sistema para ingressar:</h3>

					<div class="row my-3">
						<div class="col-md-3">
							<a class="btn btn-light bg-white border-secondary" href="{{route('dashboard.index')}}">
								<img src="{{asset('images/ts-w200.png')}}" alt="Territórios Sociais" />
								<div class="py-3">
									<div class="btn btn-light border-light">Territórios Sociais <i class="fa fa-arrow-right"></i></div>
								</div>
							</a>
						</div>
					</div>

				</div>
			</div>

		</div>


	</div>
@endsection