<template>
	<modal id="flagsFilterWnd" ref="modal">
		<strong slot="header">Selecione as etiquetas para filtrar</strong>

		<form @submit.prevent="doFilter()" slot="body" class="justify-content-around">
			<div class="form-group">
				<div class="row">
					<div class="col-md-3" v-for="(flag, i) in flags">
						<label class="checkbox">
							<input type="checkbox" v-model="selected" :name="'flags[' + i + ']'" :value="flag.id" />
							<i v-if="flag.entity_type === 'family'" class="fa fa-users"></i>
							<i v-if="flag.entity_type === 'residence'" class="fa fa-home"></i>
							<i v-if="flag.entity_type === 'person'" class="fa fa-male"></i>
							<small>{{flag.name}}</small>
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<button class="btn btn-primary pull-right" type="submit">Filtrar</button>
			</div>
		</form>
	</modal>
</template>

<script>
	import Endpoints from "../config/Endpoints";
	import axios from "axios";
	import API from "../services/API";
	import Dialogs from "../services/Dialogs";

	export default {
		props: ['selectedFlags'],

		data: () => { return {
			isLoading: false,
			flags: [],
			selected: [],
			options: [],
		}},

		mounted: function() {
			this.refreshFlags();
			if(!this.selectedFlags) return;
			this.selected = this.selectedFlags;
		},

		methods: {
			refreshFlags: function() {

				this.isLoading = true;

				axios.get(
					API.url(Endpoints.Flags.FetchAll),
					API.headers()
				).then((res) => {

					this.isLoading = false;

					this.flags = res.data.flags;

				}).catch((err) => {
					this.isLoading = false;

					console.error("FlagsFilterModal.refreshFlags: ", err);
					Dialogs.alert('Ocorreu um erro ao carregar as informações!');
				})

			},

			doFilter: function() {
				this.$close(this.selected);
			}

		}
	}
</script>
