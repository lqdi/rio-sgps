<template>
	<div class="panels__container">
		<div class="row">
			<div class="col-md-3">
				<label class="detail__label">Categorias de dados</label>

				<div class="list-group mt-3">
					<a @click="openCategory = 'IPM'" :class="{'list-group-item-primary': openCategory === 'IPM'}" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> IPM</a>
					<a @click="openCategory = 'Saúde'" :class="{'list-group-item-primary': openCategory === 'Saúde'}" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Saúde</a>
					<a @click="openCategory = 'Educação'" :class="{'list-group-item-primary': openCategory === 'Educação'}" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Educação</a>
					<a @click="openCategory = 'Emprego e Renda'" :class="{'list-group-item-primary': openCategory === 'Emprego e Renda'}" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Emprego e Renda</a>
					<a @click="openCategory = 'Assistência Social'" :class="{'list-group-item-primary': openCategory === 'Assistência Social'}" class="list-group-item small p-2 list-group-item-action"><i v-b-tooltip title="Não preenchido" class="fa fa-circle text-secondary"></i> Assistência Social</a>
				</div>
			</div>
			<div class="col-md-9">
				<label class="detail__label">Dados: <strong>{{openCategory}}</strong></label>

				<form class="card mt-3">
					<div class="card-body">
						<div class="form-group">
							<label for="fld-test">Demo Campo S/N</label>
							<div>
								<div class="form-radio form-radio-inline">
									<input class="form-radio-input" type="radio" name="yesNo" id="yesNo-yes" value="yes">
									<label class="form-radio-label" for="yesNo-yes">Sim</label>
								</div>
								<div class="form-radio form-radio-inline">
									<input class="form-radio-input" type="radio" name="yesNo" id="yesNo-no" value="no">
									<label class="form-radio-label" for="yesNo-no">Não</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="fld-test">Demo Campo TEXT</label>
							<input class="form-control" type="text" />
							<small>Preencha o endereço completo, com CEP.</small>
						</div>

						<div class="form-group">
							<label for="fld-test">Demo Campo NUM</label>
							<input class="form-control" type="number" />
						</div>

						<div class="form-group">
							<label for="fld-test">Demo Campo CHECKBOX OPTIONS</label>
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

						<div class="form-group">
							<label for="fld-test">Demo Campo RADIO OPTIONS</label>
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
					</div>
					<div class="card-footer">
						<a href="#" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Salvar dados</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
<script>
	export default {

		data: () => { return {
			openCategory: 'IPM',
		}}

	}
</script>