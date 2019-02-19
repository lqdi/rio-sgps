<template>
	<div class="panels__container forms__panel">
		<div class="row">
			<div class="col-md-3">
				<label class="detail__label">Categorias de dados</label>

				<div class="list-group mt-3">
					<a v-for="category in categories" @click="openCategory(category)" :class="{'list-group-item-primary': isCategoryOpen(category)}" class="list-group-item small p-2 list-group-item-action forms__category-link">
						<i v-if="isCategoryOpen(category)" class="fa fa-circle text-success"></i>
						<i v-if="!isCategoryOpen(category)" class="fa fa-circle text-secondary"></i>
						<span>{{category.name}}</span>
						<i v-if="category.name === 'IPM'" class="text-secondary fa fa-lock" v-b-tooltip.hover title="Somente leitura"></i>
					</a>
				</div>
			</div>
			<div class="col-md-9" v-if="view.openCategory">
				<label class="detail__label">Dados: <strong>{{view.openCategory.name}}</strong></label>

				<form class="card mt-3" @submit.prevent="saveAnswers()">
					<div class="card-body">
						<div class="form-group forms__question" v-for="question in questions" v-if="isQuestionVisible(question)">
							<label :for="'q_' + question.id">
								<span class="badge badge-secondary">{{question.code}}</span>
								<strong>{{question.title}}</strong>
								<i v-if="isReadOnly" class="text-secondary fa fa-lock" v-b-tooltip.hover title="Somente leitura"></i>
							</label>

							<div v-if="question.field_type === 'yesno'" class="form-control">
								<div class="row">
									<div class="form-radio col-md-6">
										<input :disabled="isReadOnly" class="form-radio-input" type="radio" :name="'yesno_' + question.id" v-model="answers[question.code]" :id="'yesno_' + question.id + '_yes'" :value="true">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_yes'">Sim</label>
									</div>
									<div class="form-radio col-md-6">
										<input :disabled="isReadOnly" class="form-radio-input" type="radio" :name="'yesno_' + question.id" v-model="answers[question.code]" :id="'yesno_' + question.id + '_no'" :value="false">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_no'">Não</label>
									</div>
								</div>
							</div>


							<div v-if="question.field_type === 'yesnonullable'" class="form-control">
								<div class="row">
									<div class="form-radio col-md-4">
										<input :disabled="isReadOnly" class="form-radio-input" type="radio" :name="'yesno_' + question.id" v-model="answers[question.code]" :id="'yesno_' + question.id + '_yes'" :value="true">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_yes'">Sim</label>
									</div>
									<div class="form-radio col-md-4">
										<input :disabled="isReadOnly" class="form-radio-input" type="radio" :name="'yesno_' + question.id" v-model="answers[question.code]" :id="'yesno_' + question.id + '_no'" :value="false">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_no'">Não</label>
									</div>
									<div class="form-radio col-md-4">
										<input :disabled="isReadOnly" class="form-radio-input" type="radio" :name="'yesno_' + question.id" v-model="answers[question.code]" :id="'yesno_' + question.id + '_null'" :value="null">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_null'">Não sabe / Não respondeu</label>
									</div>
								</div>
							</div>

							<div v-if="question.field_type === 'text'">
								<input :readonly="isReadOnly" class="form-control" type="text" v-model="answers[question.code]" />
							</div>

							<div v-if="question.field_type === 'date'">
								<input :readonly="isReadOnly" class="form-control" type="date" v-model="answers[question.code]" />
							</div>

							<div v-if="question.field_type === 'numeric'">
								<input :readonly="isReadOnly" class="form-control" type="tel" v-mask="(question.field_options && question.field_options.mask) ? question.field_options.mask : null" v-model="answers[question.code]" />
							</div>

							<div v-if="question.field_type === 'number'">
								<input :readonly="isReadOnly" class="form-control" type="number" v-model="answers[question.code]" />
							</div>

							<div v-if="question.field_type === 'select_one'" class="form-control">
								<div class="form-radio" v-for="(label, value) in question.field_options">
									<input :disabled="isReadOnly" class="form-radio-input" type="radio" v-model="answers[question.code]" :id="'rd_' + question.id + '_' + value" :value="value">
									<label class="form-radio-label" :for="'rd_' + question.id + '_' + value">{{label}}</label>
								</div>
							</div>

							<div v-if="question.field_type === 'select_many'" class="form-control">
								<div class="form-check">
									<input :disabled="isReadOnly" class="form-radio-input" type="checkbox" v-model="answers[question.code]" :id="'chk_' + question.id + '_' + value" :value="value">
									<label class="form-radio-label" :for="'chk_' + question.id + '_' + value">{{label}}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer" v-if="canEdit">
						<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Salvar dados</button>
					</div>

					<loading-feedback :is-loading="isLoading"></loading-feedback>
				</form>
			</div>
		</div>
	</div>
</template>
<script>
	import axios from "axios";
	import Endpoints from "../config/Endpoints";
	import API from "../services/API";
	import {checkConditions} from "../services/ConditionalChecker";
	import Dialogs from "../services/Dialogs";

	export default {

		props: ['entityType', 'entityId', 'canEdit'],

		data: () => { return {
			isLoading: false,
			isReadOnly: false,
			view: {
				openCategory: null
			},
			categories: [],
			questions: [],
			answers: {},
		}},

		mounted: function() {
			this.isReadOnly = !this.canEdit;
			this.fetchCategories()
				.then((categories) => {
					this.openCategory(categories[0]);
				});
		},

		methods: {

			isQuestionVisible: function(question) {
				return checkConditions(question.conditions, this.answers);
			},

			fetchCategories: function() {
				this.isLoading = true;

				return axios
					.get(
						API.url(Endpoints.Questions.FetchCategories),
						API.headers()
					)
					.then((res) => {
						this.isLoading = false;
						this.categories = res.data.categories;
						return this.categories;
					})
					.catch((err) => {
						this.isLoading = false;
						console.error(err);
						Dialogs.alert('Ocorreu um erro ao baixar as categorias de pergunta! Tente novamente mais tarde');
					})
			},

			fetchQuestionsByCategory: function(category) {
				this.isLoading = true;
				return axios
					.get(
						API.url(Endpoints.Questions.FetchQuestionsByEntity, {category: category.id, type: this.entityType, id: this.entityId}),
						API.headers()
					)
					.then((res) => {
						this.isLoading = false;

						this.questions = res.data.questions;
						this.answers = res.data.answers;

						return this.questions
					}).catch((err) => {
						this.isLoading = false;
						console.error(err);
						Dialogs.alert('Ocorreu um erro ao baixar os dados do formulário! Tente novamente mais tarde');
					})
			},

			saveAnswers: function() {
				if(!this.canEdit) return;

				let hasChangedProfile = false;
				this.isLoading = true;

				return axios
					.put(
						API.url(Endpoints.Questions.SaveAnswers, {type: this.entityType, id: this.entityId}),
						{answers: this.answers},						API.headers()
					)
					.then((res) => {
						console.log(res.data);
						hasChangedProfile = res.data.has_changed_profile || false;

						this.isLoading = false;

						return this.fetchQuestionsByCategory(this.view.openCategory)
					})
					.then((res) => {
						this.$toasted.show('As respostas foram salvas com sucesso!', {icon: 'fa-check'});

						if(!hasChangedProfile) return;

						this.isLoading = true;
						location.reload();
					})
					.catch((err) => {
						this.isLoading = false;
						console.error(err);
						Dialogs.alert('Ocorreu um erro ao submeter as respostas! Tente novamente mais tarde.')
					})

			},

			isCategoryOpen: function(category) {
				if(!this.view.openCategory) return false;
				return category.id === this.view.openCategory.id;
			},

			openCategory: function(category) {

				this.fetchQuestionsByCategory(category).then(() => {
					this.view.openCategory = category;
					this.isReadOnly = (category.name === 'IPM') || !this.canEdit
				})

			}

		}

	}
</script>