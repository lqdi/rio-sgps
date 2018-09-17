@php
/* @var $family \SGPS\Entity\Family */
@endphp
<div class="row">
	<div class="col-md-8">
		<label class="detail__label">FAMÍLIA</label>
		<h3>Responsável: {{$family->personInCharge->name}}</h3>
	</div>
	<div class="col-md-4">
		<label class="detail__label">ETIQUETAS</label>
		<div>
			@foreach($family->flags as $flag)
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
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Cadastro de Família</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action active"><i v-b-tooltip title="Em preenchimento" class="fa fa-circle text-warning"></i> Enquadramento no Bolsa Família</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> União civil sem registro</a>
			<a href="#" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Avaliação de assistência social</a>
		</div>
	</div>
	<div class="col-md-9">
		<label class="detail__label">Formulário: <strong>Enquadramento no Bolsa Família</strong></label>

		<form class="card mt-3">
			<div class="card-body">
				<div class="form-group">
					<label for="fld-test">Faixa de renda familiar</label>
					<div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="familyIncome" id="income-upTo500" value="upTo500">
							<label class="form-radio-label" for="income-upTo500">até R$ 500 / mês</label>
						</div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="familyIncome" id="income-500to1000" value="500to1000">
							<label class="form-radio-label" for="income-500to1000">R$ 500 a R$ 1.000 / mês</label>
						</div>
						<div class="form-radio form-radio-inline">
							<input class="form-radio-input" type="radio" name="familyIncome" id="income-over1000" value="over1000">
							<label class="form-radio-label" for="income-over1000">acima de R$ 1.000 / mês</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="fld-test">Genitora</label>
					<input class="form-control" type="text" />
					<small>Preencha o nome completo da mãe ou filiação primária, se houver</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Genitor</label>
					<input class="form-control" type="text" />
					<small>Preencha o nome completo do pai ou filiação secundária, se houver</small>
				</div>

				<div class="form-group">
					<label for="fld-test">Quantas crianças em idade escolar estão presentes na família?</label>
					<input class="form-control" type="number" />
					<div>
						<small>Indique somente as crianças do núcleo familiar selecionado, que residem na mesma residência.</small>
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