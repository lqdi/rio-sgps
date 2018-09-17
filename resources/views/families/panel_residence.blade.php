@php
/* @var $residence \SGPS\Entity\Residence */
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-8">
		<label class="detail__label">DOMICÍLIO</label>
		<h3>{{$residence->address}}</h3>
	</div>
	<div class="col-md-4">
		<label class="detail__label">ETIQUETAS</label>
		<div>
			@foreach($residence->flags as $flag)
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
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Cadastro de Domicílio</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action active"><i v-b-tooltip title="Em preenchimento" class="fa fa-circle text-warning"></i> Falta de Saneamento Básico</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Falta de Energia Elétrica</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Falta de Transporte Público</a>
		</div>
	</div>
	<div class="col-md-9">
		<label class="detail__label">Formulário: <strong>Falta de Saneamento Básico</strong></label>

		<form class="card mt-3">
			<div class="card-body">
				<div class="form-group">
					<label for="fld-test">Casa possui sistema de encanamento?</label>
					<div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="hasPlumbing" id="plumbing-yes" value="yes">
							<label class="form-radio-label" for="plumbing-yes">Sim</label>
						</div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="hasPlumbing" id="plumbing-no" value="no">
							<label class="form-radio-label" for="plumbing-no">Não</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="fld-test">Qual o endereço mais próximo que possui acesso à saneamento básico?</label>
					<input class="form-control" type="text" />
					<small>Preencha o endereço completo, com CEP.</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Houve tentativa de contato com a empresa de saneamento urbano?</label>
					<div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="hasContacted" id="contacted-yes" value="yes">
							<label class="form-radio-label" for="contacted-yes">Sim</label>
						</div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="hasContacted" id="contacted-no" value="no">
							<label class="form-radio-label" for="contacted-no">Não</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="fld-test">Quantas pessoas moram na mesma habitação?</label>
					<input class="form-control" type="number" />
				</div>
			</div>
			<div class="card-footer">
				<a href="#" class="btn btn-outline-primary"><i class="fa fa-save"></i> Salvar e continuar editando</a>
				<a href="#" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Submeter formulário</a>
			</div>
		</form>
	</div>
</div>