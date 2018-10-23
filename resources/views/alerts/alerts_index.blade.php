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
						<button disabled type="button" class="btn disabled btn-sm btn-primary">Em aberto</button>
						<button disabled type="button" class="btn disabled btn-sm btn-outline-primary">Entregues</button>
						<button disabled type="button" class="btn disabled btn-sm btn-outline-primary">Não entregues</button>
						<button disabled type="button" class="btn disabled btn-sm btn-outline-primary">Arquivados</button>
					</div>
					<div class="form-group">
						<select class="form-control form-control-sm">
							<option selected disabled>Filtrar por região censitária ... </option>
						</select>
					</div>
					<div class="form-group">
						<input disabled type="search" class="form-control disabled form-control-sm mx-2" style="width: 270px" placeholder="Buscar por nome, endereço, CPF...">
					</div>
					<div class="form-group">
						<button disabled type="button" class="btn disabled btn-sm btn-info"><i class="fa fa-print"></i> Imprimir fichas</button>
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
					<tr>
						<td colspan="5" class="text-center text-secondary py-3">Nenhum alerta recebido ainda através da busca ativa. <br/> Novos alertas aparecerão sempre que forem importados arquivos do Survey.</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
@endsection