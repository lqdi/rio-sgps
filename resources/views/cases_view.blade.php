@extends('layout')
@section('main')
	<div is="wireframe-case-view" inline-template>
		<div class="case__container">
			<div class="case__topbar">

				<div class="row">
					<div class="col-md-9">
						<h1>Caso #RJ001887</h1>
						<p><i class="fa fa-home"></i> {{$faker->streetAddress}}</p>
					</div>
					<div class="col-md-3">
						<div class="pt-3">
							<i class="fa fa-calendar"></i> Data Alerta: {{$faker->date('d/m/Y')}}
						</div>
						<div>
							<i class="fa fa-calendar"></i> Data Abertura: {{$faker->date('d/m/Y')}}
						</div>
					</div>
				</div>

			</div>

			<div class="case__sidebar">

				<a @click="openTab = 'overview'" :class="{active: openTab === 'overview'}" class="case__sidebar-link"><i class="fa fa-info-circle"></i> Visão Geral</a>
				<a @click="openTab = 'discussion'" :class="{active: openTab === 'discussion'}" class="case__sidebar-link"><i class="fa fa-comments"></i> Discussão</a>
				<a @click="openTab = 'files'" :class="{active: openTab === 'files'}" class="case__sidebar-link"><i class="fa fa-copy"></i> Arquivos</a>
				<a @click="openTab = 'tags'" :class="{active: openTab === 'tags'}" class="case__sidebar-link"><i class="fa fa-tags"></i> Etiquetas</a>

				<hr />

				<a @click="openTab = 'home'" :class="{active: openTab === 'home'}" class="case__sidebar-link"><i class="fa fa-home"></i> Domicílio</a>

				<div class="tree__container">
					<a @click="openTab = 'family'" :class="{active: openTab === 'family'}" class="tree__leaf"><i class="fa fa-sitemap"></i> Família #1</a>
					<div class="tree__children open">
						<a @click="openTab = 'member1'" :class="{active: openTab === 'member1'}" class="tree__leaf"><i class="fa fa-mars"></i> João Silva Andrade <i v-b-tooltip.hover title="Responsável" class="fa fa-star"></i></a>
						<a @click="openTab = 'member2'" :class="{active: openTab === 'member2'}" class="tree__leaf"><i class="fa fa-venus"></i> Joana Andrade</a>
						<a @click="openTab = 'member3'" :class="{active: openTab === 'member3'}" class="tree__leaf"><i class="fa fa-venus"></i> <i class="fa fa-child"></i> Mariana Silva </a>
					</div>
				</div>

			</div>

			<div class="case__detail">

				<div v-if="openTab === 'member1' || openTab === 'member2' || openTab === 'member3'">
					<div class="row">
						<div class="col-md-8">
							<label class="detail__label">INDIVÍDUO</label>
							<h3>João Silva Andrade</h3>
							<span class="badge badge-success">Responsável</span>
							<span class="badge badge-primary"><i class="fa fa-mars"></i> Masculino</span>
							<span class="badge badge-info">45 anos</span>
						</div>
						<div class="col-md-4">
							<label class="detail__label">ETIQUETAS</label>
							<div>
								@foreach($labels->shuffle()->take(rand(3,5)) as $label)
									<span class="badge badge-secondary">{{$label}}</span>
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
				</div>
			</div>
		</div>
	</div>

	@php
		$labelsModalJSON = json_encode($labels->map(function ($label) {
			return ['text' => $label, 'value' => str_slug($label)];
		}));
	@endphp

	<tags-filter-modal id="tagswnd" :options="{{$labelsModalJSON}}"></tags-filter-modal>
@endsection