@extends('layout')
@section('main')
	<div class="container">
		<div class="py-2">
			<div>
				<h1>Casos</h1>
			</div>
			<div>
				<form class="form-inline justify-content-between">
					<div class="form-group">
						<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong> &nbsp;&nbsp;
					</div>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-sm btn-primary">Em aberto</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Arquivados</button>
					</div>
					<div class="form-group">
						<input type="search" class="form-control form-control-sm mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
					</div>

					<div class="btn-group-sm" role="group">
						<button type="button" class="btn btn-sm btn-primary">Todos</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Casos em que estou envolvido</button>
					</div>

					<div class="form-group">
						<button type="button" class="btn btn-sm btn-dark mx-2" v-b-modal.tagswnd >Buscar por Etiquetas</button>
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
					<th><i class="fa fa-male"></i></th>
					<th><i class="fa fa-child"></i></th>
					<th>Etiquetas</th>
				</tr>
				</thead>
				<tbody>
				@for($i = 0; $i < 24; $i++)
					<tr>
						@php

							$numAdults = rand(1,4);
							$numChildren = rand(1,6);

							$adults = \Illuminate\Support\Collection::times($numAdults)->map(function() use ($faker) {
								return '<i class="fa ' . (rand(0,1) ? 'fa-mars' : 'fa-venus') . '"></i> ' . $faker->name;
							});

							$children = \Illuminate\Support\Collection::times($numChildren)->map(function() use ($faker) {
								return '<i class="fa ' . (rand(0,1) ? 'fa-mars' : 'fa-venus') . '"></i> ' . $faker->name;
							});

							$adultsPopoverJSON = json_encode([
								'content' => $adults->implode('<br />'),
								'html' => true,
							]);

							$childrenPopoverJSON = json_encode([
								'content' => $children->implode('<br />'),
								'html' => true,
							]);

							$caseLabels = $labels->shuffle()->take(rand(2,5));
							$visibleLabels = $caseLabels->take(2);

							$labelsPopoverJSON = json_encode([
								'html' => true,
								'content' => $caseLabels->implode('<br />'),
							]);

						@endphp
						<td><a href="{{route('wireframe.view', ['cases_view'])}}" class="btn btn-sm btn-block btn-outline-danger">RJ{{str_pad(strtoupper(dechex(rand(1000, 10000))), 6, "0", STR_PAD_LEFT)}}</a></td>
						<td>{{$faker->streetAddress}}</td>
						<td><i class="fa {{rand(0,1) === 0 ? 'fa-mars' : 'fa-venus'}}"></i> {{$faker->name}}</td>
						<td><span class="badge badge-pill badge-warning" v-b-popover.hover="{{$adultsPopoverJSON}}" title="{{$numAdults}} adultos">{{$numAdults}}</span></td>
						<td><span class="badge badge-pill badge-warning" v-b-popover.hover="{{$childrenPopoverJSON}}" title="{{$numChildren}} crianças">{{$numChildren}}</span></td>
						<td>
							@foreach($visibleLabels as $label)
								<span class="badge badge-secondary">{{$label}}</span>
							@endforeach

							@if(sizeof($caseLabels) > 2)
								<span class="badge badge-primary" v-b-popover.hover="{{$labelsPopoverJSON}}" title="Etiquetas aplicadas">+{{sizeof($caseLabels) - sizeof($visibleLabels)}}</span>
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

	<tags-filter-modal id="tagswnd" :options="{{$labelsModalJSON}}"></tags-filter-modal>
@endsection