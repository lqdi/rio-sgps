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

				<div v-if="openTab === 'overview'">
					<div class="row">
						<div class="col-md-8">
							<label class="detail__label">VISÃO GERAL</label>
							<h3>Caso #RJ001887 - {{$faker->streetAddress}}</h3>
							<div>Alerta registrado por <i class="fa fa-user"></i> {{$faker->name}}</div>
							<div>Caso aberto por <i class="fa fa-user"></i> {{$faker->name}}</div>
						</div>
						<div class="col-md-4">
							<label class="detail__label">LOCALIZAÇÃO</label>
							<div>
								<i v-b-tooltip title="Região censitária" class="fa fa-map"></i> RJ {{rand(10,99)}} {{$faker->city}}<br />
								<i v-b-tooltip title="Endereço" class="fa fa-map-marker"></i> {{$faker->streetName}}
							</div>
						</div>
					</div>

					<br />

					<div class="row">
						<div class="col-md-8">
							<label class="detail__label">EQUIPAMENTOS</label>
							<div><i class="fa fa-university"></i> CRAS {{$faker->city}}</div>
							<div><i class="fa fa-university"></i> CRE {{$faker->city}}</div>
							<div><i class="fa fa-university"></i> CSF {{$faker->city}}</div>
							<div><i class="fa fa-university"></i> CASDH {{$faker->city}}</div>
						</div>
						<div class="col-md-4">
							<label class="detail__label">SITUAÇÃO</label>
							<div>
								<h3 class="text-danger">2.3 <br /><small>pontos no IPM</small></h3>
							</div>
						</div>
					</div>

				</div>

				<div v-if="openTab === 'discussion'">
					<div class="row">
						<div class="col-md-12">
							<label class="detail__label">DISCUSSÃO</label>

							<table class="table">
								<thead>
									<tr>
										<th>Data e hora</th>
										<th>Operador</th>
										<th>Secretaria</th>
										<th>Anotação</th>
									</tr>
								</thead>
								<tbody>
									@for($i = 0; $i < 24; $i++)
										<tr>
											<td>{{$faker->date('d/m/Y H:i:s')}}</td>
											<td><i class="fa fa-user"></i> {{$faker->name}}</td>
											<td>{{$faker->randomElement(['SME', 'SMASDH', 'CRAS', 'CSF'])}}</td>
											<td>{{$faker->words(rand(8, 24), true)}}</td>
										</tr>
									@endfor
								</tbody>
							</table>

							<div class="card">
								<div class="card-header"><i class="fa fa-plus"></i> Nova anotação</div>
								<div class="card-body">
									<textarea placeholder="Digite sua anotação aqui ... " class="form-control" style="height: 100px"></textarea>
								</div>
								<div class="card-footer">
									<button type="button" class="btn btn-sm btn-primary pull-right">Registrar anotação <i class="fa fa-edit"></i></button>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div v-if="openTab === 'files'">
					<div class="row">
						<div class="col-md-12">
							<label class="detail__label">ARQUIVOS</label>

							<table class="table">
								<thead>
								<tr>
									<th>Data e hora</th>
									<th>Operador</th>
									<th>Secretaria</th>
									<th>Arquivo</th>
									<th>Descrição</th>
								</tr>
								</thead>
								<tbody>
								@for($i = 0; $i < 24; $i++)
									<tr>
										<td>{{$faker->date('d/m/Y H:i:s')}}</td>
										<td><i class="fa fa-user"></i> {{$faker->name}}</td>
										<td>{{$faker->randomElement(['SME', 'SMASDH', 'CRAS', 'CSF'])}}</td>
										<td><a class="btn btn-outline-secondary btn-sm"><i class="fa fa-download"></i> {{$faker->ean8}}.{{$faker->fileExtension}}</a></td>
										<td>{{$faker->words(rand(2, 6), true)}}</td>
									</tr>
								@endfor
								</tbody>
							</table>

							<div class="card">
								<div class="card-header"><i class="fa fa-plus"></i> Enviar arquivo</div>
								<div class="card-body">
									<label>Descrição</label>
									<input class="form-control" type="text" placeholder="Descreva o arquivo... " />

									<label>Arquivo</label>
									<input class="form-control" type="file" placeholder="Escolha o arquivo ... " />
								</div>
								<div class="card-footer">
									<button type="button" class="btn btn-sm btn-primary pull-right">Enviar <i class="fa fa-upload"></i></button>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div v-if="openTab === 'tags'">
					<div class="row">
						<div class="col-md-12">
							<label class="detail__label">ETIQUETAS</label>

							<div class="row">

								<div class="col-md-12 text-center">
									<button type="button" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Adicionar etiqueta</button>
									<hr />
								</div>

								@foreach($labels->shuffle()->take(rand(4,7)) as $label)
									<div class="col-md-3">
										<div class="card">
											<div class="card-header">
												<strong><i class="fa fa-tag"></i> {{$label}}</strong>
												<button type="button" v-b-tooltip title="Remover etiqueta" class="btn btn-sm btn-outline-danger pull-right"><i class="fa fa-trash"></i></button>
											</div>
											<div class="card-body">
												<div><i v-b-tooltip title="Data de atribuição" class="fa fa-calendar"></i> {{$faker->date('d/m/Y')}}</div>
												<div><i v-b-tooltip title="Operador responsável" class="fa fa-user"></i> {{$faker->userName}}</div>
												<div><i v-b-tooltip title="Prazo para resolução" class="fa fa-clock"></i> {{$faker->date('d/m/Y')}} (em {{rand(2, 60)}} dias)</div>
											</div>
										</div>
										<br />
									</div>
								@endforeach
							</div>
						</div>
					</div>

				</div>

				<div v-if="openTab === 'home'">
					<div class="row">
						<div class="col-md-8">
							<label class="detail__label">DOMICÍLIO</label>
							<h3>{{$faker->address}}</h3>
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
				</div>

				<div v-if="openTab === 'family'">
					<div class="row">
						<div class="col-md-8">
							<label class="detail__label">FAMÍLIA</label>
							<h3>Responsável: João Silva Andrade</h3>
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
				</div>

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