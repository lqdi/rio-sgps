<template>
	<modal id="wndArchiveMember" ref="modal">
		<strong slot="header">Arquivar ficha de membro da família</strong>
		<form slot="body" method="post" @submit.prevent="archiveMember()">
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div class="form-group">
				<label for="fld-reason"><i class="fa fa-sitemap"></i> Motivo do arquivamento:</label>
				<select id="fld-reason" class="form-control" v-model="input.reason">
					<option value="moved">Mudou-se</option>
					<option value="death">Faleceu</option>
					<option value="duplicate">Cadastro em duplicidade</option>
					<option value="invalid">Cadastro incorreto</option>
				</select>
			</div>

			<div class="form-group">
				<button class="btn btn-primary pull-right" :disabled="shouldBlockSubmit" :class="{disabled: shouldBlockSubmit}" type="submit">Arquivar</button>
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
		props: ['familyId', 'memberId'],

		data: () => { return {
			isLoading: false,
			input: {
				reason: null,
			},
		}},

		computed: {

			shouldBlockSubmit: function() {
				return (!this.input.reason);
			},

		},


		methods: {

			getEntityReference: function() {
				return {family_id: this.familyId, member_id: this.memberId}
			},

			archiveMember: async function() {

				if(this.shouldBlockSubmit) return;

				this.isLoading = true;

				return axios.post(
					API.url(Endpoints.Family.ArchiveMember, this.getEntityReference()),
					this.input,
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.$close(true);
				}).catch(async (err) => {
					this.isLoading = false;

					console.error("ArchiveMemberModal.archiveMember: ", err);

					return await Dialogs.alert('Ocorreu um erro ao salvar as informações!');
				})
			}

		}
	}
</script>