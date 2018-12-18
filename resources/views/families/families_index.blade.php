@extends('shared.layout')
@section('main')
	<div
		is="family-search"
		inline-template
		:active-filters="{{json_encode($filters)}}"
	>
		<div>
			<loading-feedback :is-loading="isLoading"></loading-feedback>
			<div class="container py-2">
				<div>
					<h1>Famílias</h1>
				</div>
				<div>
					<form ref="filterForm" @submit.prevent="doSearch()" class="form-inline justify-content-between" method="GET" action="{{route('families.index')}}">
						<div class="form-group">
							<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong> &nbsp;&nbsp;
						</div>
						<div class="btn-group" role="group">
							<input type="hidden" name="filters[status]" v-model="filters.status" />
							<button type="button" @click="setFilter('status', 'ongoing')" class="btn btn-sm {{$filters['status'] === 'ongoing' ? 'btn-primary' : 'btn-outline-primary'}}">Em aberto</button>
							<button type="button" @click="setFilter('status', 'archived')" class="btn btn-sm {{$filters['status'] === 'archived' ? 'btn-primary' : 'btn-outline-primary'}}">Arquivados</button>
						</div>
						<div class="form-group">
							<input type="search" name="filters[q]" value="{{$filters['q'] ?? ''}}" class="form-control form-control-sm mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
						</div>

						<div class="btn-group-sm" role="group">
							<input type="hidden" name="filters[assigned_to]" v-model="filters.assigned_to" />
							<button type="button" @click="setFilter('assigned_to', 'all')" class="btn btn-sm {{$filters['assigned_to'] === 'all' ? 'btn-primary' : 'btn-outline-primary'}}">Todos</button>
							<button type="button" @click="setFilter('assigned_to', 'to_me')" class="btn btn-sm {{$filters['assigned_to'] === 'to_me' ? 'btn-primary' : 'btn-outline-primary'}}">Meus casos</button>
						</div>

						<div class="form-group">
							<input v-if="filters.flags" v-for="(flag_id, i) in filters.flags" type="hidden" :name="'filters[flags][' + i + ']'" :value="flag_id" />
							<button type="button" @click="selectFlagsToFilter()" class="btn btn-sm btn-dark mx-2">Filtrar por Etiquetas</button>
						</div>

						<div class="form-group">
							<button type="button" @click="exportResults(filters)" class="btn btn-sm btn-dark mx-2">Exportar <span class="badge badge-primary">{{$families->total()}}</span> <i class="fa fa-download"></i></button>
						</div>
					</form>
				</div>
			</div>
			<div class="container-fluid">
				<div class="py-2">

					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>Domicílio</th>
							<th>Responsável do domicílio</th>
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
									<flag-display-tooltip :flags="{{json_encode($family->allActiveFlags)}}"></flag-display-tooltip>
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
		</div>
	</div>

@endsection