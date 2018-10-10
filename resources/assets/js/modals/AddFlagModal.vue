<template>
	<modal id="wndAddFlag" ref="modal">
		<strong slot="header">Adicionar etiqueta</strong>
		<form slot="body" method="post" @submit.prevent="addFlagToEntity()">
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div class="form-group">
				<label for="fld-entityType"><i class="fa fa-sitemap"></i> Entidade:</label>
				<select id="fld-entityType" class="form-control" v-model="entityType" @input="onEntityTypeChange()">
					<option value="family">Família</option>
					<option value="residence">Residência</option>
					<option value="person">Membro da Família</option>
				</select>
			</div>

			<div class="form-group" v-if="entityType === 'person'">
				<label for="fld-entityID"><i class="fa fa-male"></i> Membro:</label>
				<select id="fld-entityID" class="form-control" v-model="entityID">
					<option v-for="member in family.members" :value="member.id">{{member.name}}</option>
				</select>
			</div>

			<div class="form-group">
				<label for="fld-flag_id"><i class="fa fa-tag"></i> Etiqueta:</label>
				<b-form-select id="fld-flag_id" v-model="input.flag_id" :options="options"></b-form-select>
			</div>

			<div class="form-group">
				<label for="fld-reference_date"><i class="fa fa-calendar"></i> Data de referência / início:</label>
				<input id="fld-reference_date" class="form-control" v-model="input.reference_date" type="date" />
			</div>

			<div class="form-group">
				<label for="fld-deadline"><i class="fa fa-clock-o"></i> Prazo (em dias corridos)</label>
				<input id="fld-deadline" class="form-control" v-model="input.deadline" type="number" min="1" max="365" />
			</div>

			<div class="form-group">
				<button class="btn btn-primary pull-right" type="submit" :disabled="shouldBlockSubmit" :class="{disabled: shouldBlockSubmit}">Adicionar etiqueta</button>
			</div>
		</form>
	</modal>
</template>

<script>
	import axios from "axios";
	import moment from "moment";

	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import Dialogs from "../services/Dialogs";

	export default {
		props: ['family'],

		data: () => { return {
			isLoading: false,
			flags: [],


			input: {
				flag_id: null,
				reference_date: null,
				deadline: 30,
			},
			entityType: 'family',
			entityID: null,
		}},

		computed: {

			shouldBlockSubmit: function() {
				if(!this.input.flag_id) return true;
				if(!this.input.reference_date) return true;
				if(!this.input.deadline) return true;
				if(this.entityType !== 'person') return false;
				return (this.entityID === null);
			},

			options: function() {
				return this.flags
					.filter((flag) => flag.entity_type === this.entityType)
					.map((flag) => {
						return {text: flag.name, value: flag.id}
					})
			},

		},

		mounted: async function() {
			this.input.reference_date = moment().format('Y-M-D');
			this.entityID = this.family.id;

			this.refreshFlags();
		},

		methods: {

			onEntityTypeChange: function() {
				this.input.flag_id = null;
			},

			refreshFlags: async function() {
				this.isLoading = true;

				axios.get(
					API.url(Endpoints.Flags.FetchAll),
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.flags = res.data.flags;
				}).catch(async (err) => {
					this.isLoading = false;
					console.error("AddFlagModal.refreshFlags: ", err);
					await Dialogs.alert('Ocorreu um erro ao carregar as informações!');
				})
			},

			getEntityReference: function() {
				if(this.entityType === 'family') {
					this.entityID = this.family.id;
				} else if(this.entityType === 'residence') {
					this.entityID = this.family.residence_id;
				}

				return {type: this.entityType, id: this.entityID};
			},

			addFlagToEntity: async function() {

				if(this.shouldBlockSubmit) return;

				this.isLoading = true;

				return axios.post(
					API.url(Endpoints.Flags.AddToEntity, this.getEntityReference()),
					this.input,
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.$close(true);
				}).catch(async (err) => {
					this.isLoading = false;

					console.error("AddFlagModal.addFlagToEntity: ", err);

					if(err.response.data.reason === 'flag_already_exists') {
						return await Dialogs.alert('A etiqueta selecionada já está aplicada nessa entidade!');
					}

					return await Dialogs.alert('Ocorreu um erro ao salvar as informações!');
				})
			}

		}
	}
</script>