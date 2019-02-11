@extends('shared.layout')
@section('main')
	<div
			is="operator-dashboard"
			inline-template
	>
		<div>
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div class="container-fluid py-3">
				<div class="row">
					<div class="col-md-6">

						<div class="card">
							<div class="card-body">
								<h2><i class="fa fa-user"></i> <small>Bem vindo(a),</small> {{$user->getFirstName()}}</h2>

								<div class="row pt-3">
									<div class="col-md-6">
										<dl>
											<dt><i class="fa fa-cog"></i> Tipo:</dt>
											<dd><strong class="badge badge-primary">{{trans('user.level.' . $user->level)}}</strong></dd>
											<dt><i class="fa fa-users"></i> Grupos:</dt>
											<dd>
												@if(sizeof($user->groups) > 0)
													@foreach($user->groups as $group) <span class="badge badge-secondary">{{$group->name}}</span> @endforeach
												@else
													<span class="badge badge-light">Nenhum</span>
												@endif
											</dd>
										</dl>
									</div>
									<div class="col-md-6">
										<dl>
											<dt><i class="fa fa-map-marker"></i> Equipamentos:</dt>
											<dd>
												@if(sizeof($user->equipments) > 0)
													@foreach($user->equipments as $equipment) <span class="badge badge-secondary">{{$equipment->name}}</span> @endforeach
												@else
													<span class="badge badge-light">Nenhum</span>
												@endif
											</dd>
											<dt><i class="fa fa-tag"></i> Código: </dt>
											<dd>
												<strong><code>{{$user->id}}</code></strong>
											</dd>
										</dl>
									</div>
								</div>


							</div>
							<div class="card-footer">
								<a href="#" class="btn btn-light pull-right"><i class="fa fa-cog"></i> Minhas configurações</a>
							</div>
						</div>

						<br />

						<div class="card">
							<div class="card-header">
								<strong><i class="fa fa-check-square"></i> Casos que estou envolvido</strong>
							</div>
							<div class="card-body">

								<div class="row">

									<table class="table">
										<thead>
										<tr>
											<th>Cód.</th>
											<th>Tipo</th>
											<th>Endereço</th>
											<th>Responsável</th>
										</tr>
										</thead>
										<tbody>

										@if(sizeof($myAssignments) <= 0)
											<tr>
												<td colspan="3" class="text-center text-secondary">Nenhum caso atribuido à mim!</td>
											</tr>
										@endif

										@foreach($myAssignments as $assignment)
											@php /* @var $assignment \SGPS\Entity\UserAssignment */ @endphp
											<tr>
												<td>
													<a href="{{route('families.show', [$assignment->entity->id])}}" class="btn btn-sm text-danger btn-outline-danger">{{$assignment->entity->shortcode}}</a>
												</td>
												<td>
													@if($assignment->type === 'watching') <i class="fa fa-eye"></i> Observando @endif
													@if($assignment->type === 'acting') <i class="fa fa-suitcase"></i> Atuando @endif
													@if($assignment->type === 'creator') <i class="fa fa-star"></i> Operador inicial @endif
												</td>
												<td>
													<small><strong>{{$assignment->entity->residence->address ?? '---'}}</strong></small>
												</td>
												<td>
													<small><strong>{{$assignment->entity->personInCharge->name ?? '---'}}</strong></small>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>

								</div>

							</div>
						</div>

					</div>

					<div class="col-md-6">

						<b-card no-body>
							<b-tabs card>
								<b-tab active>
									<template slot="title">
										<strong><i class="fa fa-tags"></i> <i class="fa fa-users"></i> Etiquetas sob meus grupos</strong>
									</template>
									<b-card-body>
										<div class="row">
											@include('components.flag_attribution_list', ['attributions' => $myGroupAttributions])
										</div>
									</b-card-body>
								</b-tab>
								<b-tab>
									<template slot="title">
										<strong><i class="fa fa-tags"></i> <i class="fa fa-map-marker"></i> Etiquetas sob meus equipamentos</strong>
									</template>
									<b-card-body>
										<div class="row">
											@include('components.flag_attribution_list', ['attributions' => $myEquipmentAttributions])
										</div>
									</b-card-body>
								</b-tab>

							</b-tabs>
						</b-card>

					</div>

				</div>

				<br />

				<div class="row">


					<div class="col-md-12">

						<div class="card">
							<div class="card-header">
								<strong><i class="fa fa-chart"></i> Métricas do sistema</strong>
							</div>
							<div class="card-body">

								<dashboard-metrics :metrics-to-view="{{json_encode(auth()->user()->getMetricsToView()->toArray())}}"></dashboard-metrics>

							</div>
						</div>

					</div>

				</div>

			</div>
		</div>
	</div>
@endsection