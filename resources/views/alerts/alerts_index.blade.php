@extends('shared.layout')
@section('main')
	<div class="container">
		<div class="py-2">
			<div>
				<h1>Alertas</h1>
			</div>
			<div>
				<form class="form-inline justify-content-between">
					<div class="form-group">
						<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong> &nbsp;&nbsp;
					</div>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-sm btn-primary">Em aberto</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Entregues</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Não entregues</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Arquivados</button>
					</div>
					<div class="form-group">
						<select class="form-control form-control-sm">
							<option selected disabled>Filtrar por região censitária ... </option>
						</select>
					</div>
					<div class="form-group">
						<input type="search" class="form-control form-control-sm mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Imprimir fichas</button>
					</div>
				</form>
			</div>
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
				</tr>
				</thead>
				<tbody>
				@for($i = 0; $i < 24; $i++)
					<tr>
						@php
							$statusRandom = rand(1, 100);
						@endphp
						<td><a href="{{route('wireframe.view', ['cases_view'])}}" class="btn btn-sm btn-block btn-outline-danger">RJ{{str_pad(strtoupper(dechex(rand(1000, 10000))), 6, "0", STR_PAD_LEFT)}}</a></td>
						<td>{{$faker->streetAddress}}</td>
						<td><i class="fa {{rand(0,1) === 0 ? 'fa-mars' : 'fa-venus'}}"></i> {{$faker->name}}</td>
						<td>RJ {{rand(10, 99)}} {{$faker->city}}</td>
						<td>
							@if($statusRandom > 70)
								<a href="#" v-b-modal.updatewnd v-b-tooltip title="Entregue em 25/07/2018" class="btn btn-sm btn-block btn-success">Ficha Entregue - No Prazo</a>
							@elseif($statusRandom > 60)
								<a href="#" v-b-modal.updatewnd v-b-tooltip title="Entregue em 25/07/2018" class="btn btn-sm btn-block btn-warning">Re-entregar - 1a tentativa</a>
							@elseif($statusRandom > 50)
								<a href="#" v-b-modal.updatewnd v-b-tooltip title="Entregue em 25/07/2018" class="btn btn-sm btn-block btn-warning">Re-entregar - 2a tentativa</a>
							@elseif($statusRandom > 45)
								<a href="#" v-b-modal.updatewnd v-b-tooltip title="Entregue em 25/07/2018" class="btn btn-sm btn-block btn-danger">Visita Técnica</a>
							@else
								<a href="#" v-b-modal.updatewnd v-b-tooltip title="Alerta recebido em 25/07/2018" class="btn btn-sm btn-block btn-info">Entrega pendente</a>
							@endif
						</td>
					</tr>
				@endfor
				</tbody>
			</table>

		</div>
	</div>

	@php
		$labelsModalJSON = json_encode($labels->map(function ($label) {
			return ['text' => $label, 'value' => str_slug($label)];
		}));
	@endphp

	<wireframe-alert-update id="updatewnd"></wireframe-alert-update>
@endsection