<template>
	<modal id="wndArchiveMember" ref="modal">
		<strong slot="header">Exportar resultados</strong>
		<div slot="body">
			<loading-feedback :is-loading="isLoading"></loading-feedback>

			<div v-if="!downloadURL">
				<div class="form-group">
					<button @click="generateExport('family')" class="btn btn-primary" type="button"><i class="fa fa-users"></i> Famílias</button>

					<button @click="generateExport('residence')" class="btn btn-primary" type="button"><i class="fa fa-home"></i> Residências</button>

					<button @click="generateExport('person')" class="btn btn-primary" type="button"><i class="fa fa-user"></i> Indivíduos</button>
				</div>
			</div>

			<div class="form-group" v-if="downloadURL">
				<a @click="close()" :href="downloadURL" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Baixar arquivo</a>
			</div>
		</div>
	</modal>
</template>

<script>
	import axios from "axios";

	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import Dialogs from "../services/Dialogs";

	const EXPORT_ENDPOINTS = {
		family: Endpoints.Export.Families,
		residence: Endpoints.Export.Residences,
		person: Endpoints.Export.Persons,
	};

	export default {
		props: ['filters'],

		data: () => { return {
			isLoading: false,
			downloadURL: null,
		}},

		computed: {

		},


		methods: {

			generateExport: async function (entityType) {

				if(!EXPORT_ENDPOINTS[entityType]) return;

				let endpoint = EXPORT_ENDPOINTS[entityType];

				this.isLoading = true;

				return axios.post(
					API.url(endpoint),
					{filters: this.filters},
					API.headers()
				).then(async (res) => {
					this.isLoading = false;

					if (!res.data.download_url) {
						return await Dialogs.alert('Ocorreu um erro ao exportar os dados! (err: ' + res.data.reason + ')');
					}

					this.downloadURL = res.data.download_url;

				}).catch(async (err) => {
					this.isLoading = false;

					console.error("ExportModal.export: ", entityType, err);

					return await Dialogs.alert('Ocorreu um erro ao exportar os dados! (err: exception)');
				})


			},

			close: function() {
				this.$nextTick(() => {
					this.$close(true);
				})
			}

		}
	}
</script>