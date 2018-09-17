@php
/* @var $family \SGPS\Entity\Family */
/* @var $member \SGPS\Entity\Person */
@endphp
<div class="row">
	<div class="col-md-8">
		<label class="detail__label">INDIVÍDUO</label>
		<h3>{{$member->name}}</h3>
		@if($member->id === $family->person_in_charge_id)<span class="badge badge-success">Responsável</span>@endif
		<span class="badge badge-primary">{{$member->gender}}</span>
		<span class="badge badge-info">{{$member->getAge()}} anos</span>
	</div>
	<div class="col-md-4">
		<label class="detail__label">ETIQUETAS</label>
		<div>
			@foreach($member->flags as $flag)
				<span class="badge badge-secondary">{{$flag->name}}</span>
			@endforeach
		</div>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-md-3">
		<label class="detail__label">FORMULÁRIOS</label>

		<div class="list-group mt-3">
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Preenchido" class="fa fa-circle text-success"></i> Formulário de Alerta / PNUD</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Cadastro de Índivíduo</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action active"><i v-b-tooltip title="Em preenchimento" class="fa fa-circle text-warning"></i> Indivíduo sem Documento</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Rematrícula de Criança Fora da Escola</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Situação de Desemprego</a>
		</div>
	</div>
	<div class="col-md-9">
		<label class="detail__label">Formulário: <strong>Indivíduo sem Documento</strong></label>

		<form class="card mt-3">
			<div class="card-body">
				<div class="form-group">
					<label for="fld-test">Nome completo do indivíduo</label>
					<input class="form-control" type="text" />
					<small>Preencha com o nome completo do indivíduo, conforme deverá aparecer nos documentos</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Filiação primária</label>
					<input class="form-control" type="text" />
					<small>Preencha o nome completo da mãe ou filiação primária, se houver</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Filiação secundária</label>
					<input class="form-control" type="text" />
					<small>Preencha o nome completo do pai ou filiação secundária, se houver</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Documentos faltantes</label>
					<div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="missingDocuments" id="doc-rg" value="rg">
							<label class="form-check-label" for="doc-rg">RG</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="missingDocuments" id="doc-cpf" value="cpf">
							<label class="form-check-label" for="doc-cpf">CPF</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="missingDocuments" id="doc-ctps" value="ctps">
							<label class="form-check-label" for="doc-ctps">Carteira de Trabalho (CTPS)</label>
						</div>
					</div>
					<div>
						<small>Indique acima quais documentos estão faltando ao indivíduo.</small>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<a href="#" class="btn btn-outline-primary"><i class="fa fa-save"></i> Salvar e continuar editando</a>
				<a href="#" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Submeter formulário</a>
			</div>
		</form>
	</div>
</div>