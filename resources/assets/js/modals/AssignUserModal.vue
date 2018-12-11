<template>
	<modal id="wndAssignUser" ref="modal">
		<strong slot="header">Atribuir operador</strong>
		<form slot="body" method="post" @submit.prevent="assignUserToEntity()">
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div class="form-group">
				<label for="fld-assignment_type"><i class="fa fa-sitemap"></i> Tipo de atribuição:</label>
				<select id="fld-assignment_type" class="form-control" v-model="input.assignment_type">
					<option value="watching">Observando o caso</option>
					<option value="acting">Atuando no caso</option>
				</select>
			</div>

			<div class="form-group">
				<label for="fld-user_id"><i class="fa fa-user"></i> Operador:</label>
				<multiselect
						v-model="selectedUser"
						track-by="id"
						placeholder="Selecione um usuário"
						label="searchable_name"
						@input="input.user_id = selectedUser.id"
						:options="availableUsers"
						id="fld-user_id"
				></multiselect>
			</div>

			<div class="form-group">
				<button class="btn btn-primary pull-right" type="submit" :disabled="shouldBlockSubmit" :class="{disabled: shouldBlockSubmit}">Associar operador</button>
			</div>
		</form>
	</modal>
</template>

<script>
	import axios from "axios";

	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import Dialogs from "../services/Dialogs";

	export default {
		props: ['family'],

		data: () => { return {
			isLoading: false,
			users: [],
			selectedUser: null,

			input: {
				assignment_type: null,
				user_id: null,
			},
		}},

		computed: {

			availableUsers: function() {
				if(!this.users) return [];

				return Object.values(this.users).map((user) => {
					user.searchable_name = `${user.name} (${user.registration_number})`;
					return user;
				});
			},

			shouldBlockSubmit: function() {
				return (!this.input.user_id || !this.input.assignment_type);
			},

		},

		mounted: async function() {
			this.refreshUsers();
		},

		methods: {

			getEntityReference: function() {
				return {entity: API.getEntityReference('family', this.family.id)}
			},

			refreshUsers: async function() {
				this.isLoading = true;

				axios.get(
					API.url(Endpoints.Assignments.FetchAssignableUsers, this.getEntityReference()),
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.users = res.data.users;
				}).catch(async (err) => {
					this.isLoading = false;
					console.error("AssignUserModal.refreshUsers: ", err);
					await Dialogs.alert('Ocorreu um erro ao carregar as informações!');
				})
			},

			assignUserToEntity: async function() {

				if(this.shouldBlockSubmit) return;

				this.isLoading = true;

				return axios.post(
					API.url(Endpoints.Assignments.AssignUserToEntity, this.getEntityReference()),
					this.input,
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.$close(true);
				}).catch(async (err) => {
					this.isLoading = false;

					console.error("AssignUserModal.assignUserToEntity: ", err);

					if(err.response.data.reason === 'user_already_assigned') {
						return await Dialogs.alert('O usuário já está atribuido à esse caso!');
					}

					return await Dialogs.alert('Ocorreu um erro ao salvar as informações!');
				})
			}

		}
	}
</script>