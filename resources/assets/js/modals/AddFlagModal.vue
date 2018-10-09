<template>
	<b-modal :id="id" ref="modal" v-model="isOpen" hide-footer title="Adicionar etiqueta">
		<div>
			<div class="form-group">
				<label>Entidade</label>
				<select class="form-control" v-model="entityType">
					<option value="family">Família</option>
					<option value="residence">Residência</option>
					<option value="member">Membro da Família</option>
				</select>
				<select v-if="entityType === 'person'" class="form-control" v-model="entityId">
					<option v-for="member in members" :value="member.id">{{member.name}}</option>
				</select>
			</div>
			<div class="form-group">
				<label>Etiquetas:</label>
				<b-form-select v-model="selected" :options="options"></b-form-select>
			</div>
		</div>
	</b-modal>
</template>

<script>
	import axios from "axios";
	import API from "../services/API";
	import Endpoints from "../config/Endpoints";

	export default {
		props: ['id', 'family', 'residence', 'members'],

		data: () => { return {
			isOpen: false,
			flags: [],
			selected: null,
			entityType: 'family',
			entityId: null,
		}},

		mounted: async function() {
			this.refreshFlags();
		},

		methods: {

			refreshFlags: function() {
				axios.get(
					Endpoints.Flags.FetchAll,
					API.headers()
				).then((res) => {
					this.flags = res.data.flags;

					this.options = this.flags.map((option) => {
						return {
							text: option.name,
							value: option.id
						}
					})
				})
			},

		}
	}
</script>