@extends('layout')
@section('main')
	<div class="row py-2">
		<div class="col-md-12">
			<h1>Casos</h1>
		</div>
		<div class="col-md-12">
			<form class="form-inline justify-content-between">
				<div class="form-group">
					<i class="fa fa-filter"></i> &nbsp; <strong>Filtrar por</strong>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary">Em aberto</button>
					<button type="button" class="btn btn-outline-primary">Arquivados</button>
				</div>
				<div class="form-group">
					<input type="search" class="form-control mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
				</div>

				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary">Todos</button>
					<button type="button" class="btn btn-outline-primary">Casos em que estou envolvido</button>
				</div>

				<div class="form-group">
					<button type="button" class="btn btn-dark mx-2">Buscar por Etiquetas</button>
				</div>
			</form>
		</div>

		<div class="col-md-12 py-2">

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
						<td>X1234AB</td>
						<td>Rua Frederico Guarinon, 419 ap 272 casa 2</td>
						<td><i class="fa fa-mars"></i> João Silva Andrade</td>
						<td><span class="badge badge-pill badge-warning">3</span></td>
						<td><span class="badge badge-pill badge-warning">2</span></td>
						<td>
							<span class="badge badge-secondary">Criança fora da escola</span>
							<span class="badge badge-secondary">Desemprego</span>
							<span class="badge badge-primary">...</span>
						</td>
					</tr>
					@endfor
				</tbody>
			</table>

		</div>

	</div>
@endsection