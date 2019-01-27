@inject('permissions', SGPS\Services\UserPermissionsService)
@extends('shared.layout')
@section('main')
	<div
			is="family-search"
			inline-template
			:active-filters="{{json_encode($filters)}}"
	>
		<div>
			<div class="container">
				<div class="py-2">
					<div>
						<h1>Alertas</h1>
					</div>
					<div>
						<div class="row">
							<div class="col-md-8">
								<form ref="filterForm" @submit.prevent="doSearch()" class="form-inline justify-content-between" method="GET" action="{{route('alerts.index')}}">
									<div class="form-group">
										<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong> &nbsp;&nbsp;
									</div>
									<div class="btn-group" role="group">
										<input type="hidden" name="filters[visit_status]" v-model="filters.visit_status" />
										<button @click="setFilter('visit_status', 'pending')" type="button" class="btn btn-sm {{($filters['visit_status'] ?? null) === 'pending' ? 'btn-primary' : 'btn-outline-primary'}}">Pendentes</button>
										<button @click="setFilter('visit_status', 'delivered')" type="button" class="btn btn-sm {{($filters['visit_status'] ?? null) === 'delivered' ? 'btn-primary' : 'btn-outline-primary'}}">Entregues</button>
										<button @click="setFilter('visit_status', 'noshow')" type="button" class="btn btn-sm {{($filters['visit_status'] ?? null) === 'noshow' ? 'btn-primary' : 'btn-outline-primary'}}">Não compareceram</button>
									</div>
									<div class="form-group">
										<select @change="doSearch()" class="form-control form-control-sm" name="filters[sector_id]">
											<option value="" disabled @if(!isset($filters['sector_id']) || strlen($filters['sector_id']) <= 0) selected @endif >Filtrar por região censitária ... </option>
											<option value="">-- Todas as regiões --</option>
											@foreach($sectors as $sector)
												<option @if(isset($filters['sector_id']) && strval($filters['sector_id']) === strval($sector->id)) selected @endif value="{{$sector->id}}">{{$sector->name}}</option>
											@endforeach
										</select>
									</div>
								</form>
							</div>
							<div class="col-md-3">
								<form method="GET" action="{{route('alerts.index')}}" class="form-inline justify-content-between">
									<div class="form-group">
										<input type="search" name="filters[q]" value="{{$filters['q'] ?? ''}}" class="form-control form-control-sm mx-2" style="width: 200px" placeholder="Buscar ...">
									</div>
								</form>
							</div>
							<div class="col-md-1">
								<form method="GET" action="{{route('alerts.print_all_referrals')}}" class="form-inline justify-content-between">
									<input type="hidden" name="filters[visit_status]" v-model="filters.visit_status" />
									<input type="hidden" name="filters[sector_id]" v-model="filters.sector_id" />
									<input type="hidden" name="filters[q]" v-model="filters.q" />
									<div class="form-group">
										<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Imprimir fichas</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					@include('components.messages')
				</div>
			</div>
			<div class="container-fluid">
				<div class="py-2">

					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>Domicílio</th>
							<th>Responsável</th>
							<th>Região</th>
							<th>Status</th>
							<th>Opções</th>
						</tr>
						</thead>
						<tbody>
						@if(sizeof($alerts) <= 0)
							<tr>
								<td colspan="6" class="text-center text-secondary py-3">Nenhum alerta recebido ainda através da busca ativa. <br/> Novos alertas aparecerão sempre que forem importados arquivos do Survey.</td>
							</tr>
						@else
							@foreach($alerts as $alert) @php /* @var $alert \SGPS\Entity\Family */ @endphp
							<tr>
								<td>{{$alert->shortcode}}</td>
								<td>{{$alert->residence->address}}</td>
								<td>{{$alert->personInCharge->name ?? '---'}}</td>
								<td>{{$alert->sector->name ?? "{$alert->sector_id} (não cadastrada)"}}</td>
								<td>
									@if($alert->visit_status === \SGPS\Entity\Family::VISIT_PENDING_AGENT)
										<div class="badge badge-primary">Aguardando visita</div>
									@elseif($alert->visit_status === \SGPS\Entity\Family::VISIT_DELIVERED)
										<div class="badge badge-info">Entregue, Aguard. Visita</div>
									@elseif($alert->visit_status === \SGPS\Entity\Family::VISIT_LATE_TO_CRAS)
										<div class="badge badge-warning">Não compareceu ao CRAS</div>
									@elseif($alert->visit_status === \SGPS\Entity\Family::VISIT_PENDING_TECHNICAL_VISIT)
										<div class="badge badge-danger">Aguardando Visita Técnica</div>
									@endif
								</td>
								<td>
									<form onsubmit="return confirm('Tem certeza que deseja ABRIR o caso? Essa operação não pode ser cancelada.')" class="d-inline-block" method="POST" action="{{route('alerts.open_case', [$alert->id])}}">
										@csrf
										<button type="submit" class="btn btn-sm btn-light" v-b-tooltip title="Abrir caso"><i class="fa fa-folder-open"></i></button>
									</form>

									@if($permissions->canEditEntity(auth()->user(), $alert) && in_array($alert->visit_status, [\SGPS\Entity\Family::VISIT_PENDING_AGENT, \SGPS\Entity\Family::VISIT_LATE_TO_CRAS]))
										<form class="d-inline-block" method="POST" action="{{route('alerts.mark_as_delivered', [$alert->id])}}">
											@csrf
											<button type="submit" class="btn btn-sm btn-light" v-b-tooltip title="Marcar encaminhamento como entregue"><i class="fa fa-check"></i></button>
										</form>
									@endif

									<a target="_blank" href="{{route('alerts.print_referral', [$alert->id])}}" class="btn btn-sm btn-light" v-b-tooltip title="Imprimir encaminhamento"><i class="fa fa-print"></i></a>
								</td>
							</tr>
							@endforeach
						@endif
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
@endsection