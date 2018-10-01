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
					</a>
				</div>
			</div>
			<div class="col-md-9">
				<label class="detail__label">Dados: <strong>{{view.openCategory.name}}</strong></label>

				<form class="card mt-3">
					<div class="card-body">
						<div class="form-group forms__question" v-for="question in questions">
							<label :for="'q_' + question.id">
								<span class="badge badge-secondary">{{question.code}}</span>
								<strong>{{question.title}}</strong>
							</label>

							<div v-if="question.field_type === 'yesno'" class="form-control">
								<div class="row">
									<div class="form-radio col-md-6">
										<input class="form-radio-input" type="radio" name="yesNo" :id="'yesno_' + question.id + '_yes'" :value="1">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_yes'">Sim</label>
									</div>
									<div class="form-radio col-md-6">
										<input class="form-radio-input" type="radio" name="yesNo" :id="'yesno_' + question.id + '_no'" :value="0">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_no'">Não</label>
									</div>
								</div>
							</div>


							<div v-if="question.field_type === 'yesnonullable'" class="form-control">
								<div class="row">
									<div class="form-radio col-md-4">
										<input class="form-radio-input" type="radio" name="yesNo" :id="'yesno_' + question.id + '_yes'" :value="1">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_yes'">Sim</label>
									</div>
									<div class="form-radio col-md-4">
										<input class="form-radio-input" type="radio" name="yesNo" :id="'yesno_' + question.id + '_no'" :value="0">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_no'">Não</label>
									</div>
									<div class="form-radio col-md-4">
										<input class="form-radio-input" type="radio" name="yesNo" :id="'yesno_' + question.id + '_null'" :value="null">
										<label class="form-radio-label" :for="'yesno_' + question.id + '_null'">Não sabe / Não respondeu</label>
									</div>
								</div>
							</div>

							<div v-if="question.field_type === 'text'">
								<input class="form-control" type="text" />
							</div>

							<div v-if="question.field_type === 'date'">
								<input class="form-control" type="date" />
							</div>

							<div v-if="question.field_type === 'number'">
								<input class="form-control" type="number" />
							</div>

							<div v-if="question.field_type === 'select_one'" class="form-control">
								<div class="form-radio" v-for="(label, value) in question.field_options">
									<input class="form-radio-input" type="radio" v-model="question.answer" :id="'rd_' + question.id + '_' + value" :value="value">
									<label class="form-radio-label" :for="'chk_' + question.id + '_' + value">{{label}}</label>
								</div>
							</div>

							<div v-if="question.field_type === 'select_many'" class="form-control">
								<div class="form-check">
									<input class="form-radio-input" type="checkbox" v-model="question.answer" :id="'rd_' + question.id + '_' + value" :value="value">
									<label class="form-radio-label" :for="'chk_' + question.id + '_' + value">{{label}}</label>
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
	import axios from "axios";
	import Endpoints from "../config/Endpoints";
	import API from "../services/API";

	export default {

		props: ['entityType', 'entityId'],

		data: () => { return {
			view: {
				openCategory: null
			},
			categories: [],
			questions: [],
			answers: {},
		}},

		mounted() {
			this.fetchCategories()
				.then((categories) => {
					this.openCategory(categories[0]);
				})
		},

		methods: {

			fetchCategories() {
				return axios
					.get(
						API.url(Endpoints.Questions.FetchCategories),
						API.headers()
					)
					.then((res) => {
						this.categories = res.data.categories;
						return this.categories;
					})
			},

			fetchQuestionsByCategory(category) {
				return axios
					.get(
						API.url(Endpoints.Questions.FetchQuestionsByEntity, {category: category.id, type: this.entityType, id: this.entityId}),
						API.headers()
					)
					.then((res) => {
						this.questions = res.data.questions;
						return this.questions
					})
			},

			isCategoryOpen(category) {
				if(!this.view.openCategory) return false;
				return category.id === this.view.openCategory.id;
			},

			openCategory(category) {

				this.fetchQuestionsByCategory(category).then(() => {
					this.view.openCategory = category;
				})

			}

		}

	}
</script>