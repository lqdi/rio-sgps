@extends('shared.layout')
@section('main')
	<div class="container">
		<div class="py-2">
			<div>
				<h1>Famílias</h1>
			</div>
			<div>
				<form class="form-inline justify-content-between" method="GET" action="{{route('families.index')}}">
					<div class="form-group">
						<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong> &nbsp;&nbsp;
					</div>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-sm btn-primary">Em aberto</button>
						<button type="button" class="btn btn-sm btn-outline-primary">Arquivados</button>
					</div>
					<div class="form-group">
						<input type="search" name="q" class="form-control form-control-sm mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
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
					<th>Etiquetas</th>
				</tr>
				</thead>
				<tbody>
				@foreach($families as $family)
					@php /* @var $family \SGPS\Entity\Family */ @endphp
					<tr>
						<td><a href="{{route('families.show', [$family->id])}}" class="btn btn-sm btn-block btn-outline-danger"><code>{{$family->shortcode}}</code></a></td>
						<td>{{$family->residence->address}}</td>
						<td><i class="fa fa-male"></i> {{$family->personInCharge->name}}</td>
						<td>
							<flag-display-tooltip :flags="{{json_encode($family->flags)}}"></flag-display-tooltip>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

			<div class="align-items-center">
				<div class="align-self-center">
					{!! $families->links() !!}
				</div>
			</div>

		</div>
	</div>

	<flags-filter-modal id="tagswnd" :flags="{{json_encode($flags)}}"></flags-filter-modal>
@endsection