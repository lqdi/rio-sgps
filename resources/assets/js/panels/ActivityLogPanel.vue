<template>
	<div class="activity__panel">

		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<table class="table">
			<thead>
				<tr>
					<th>Data e hora</th>
					<th>Operador</th>
					<th>Atividade</th>
					<th>Detalhes</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="entry in entries">
					<td width="15">{{entry.created_at | moment('DD/MM/YYYY HH:mm:ss')}}</td>
					<td width="15">
						<div v-if="entry.causer_type === 'user'">
							<i class="fa fa-user"></i> {{entry.causer.name}}
						</div>
						<div v-if="entry.causer_type !== 'user'">
							<i class="fa fa-cog"></i> Sistema: {{entry.causer_type}}
						</div>
					</td>
					<td width="15">{{logRenderer.renderDescription(entry.description)}}</td>
					<td width="55">
						<table v-if="entry.properties">
							<tr v-for="(value, key) in entry.properties">
								<td><strong>{{logRenderer.renderKey(key)}}</strong></td>
								<td><code>{{logRenderer.renderValue(key, value)}}</code></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr v-if="!entries || entries.length <= 0" class="text-center text-danger">
					<td colspan="4">Nenhuma atividade registrada!</td>
				</tr>
			</tbody>
		</table>

	</div>
</template>
<script>

	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import axios from "axios";
	import ActivityLogRenderer from "../services/ActivityLogRenderer";

	export default {
		props: ['entityType', 'entityId'],

		data: () => { return {
			logRenderer: ActivityLogRenderer,
			entries: [],
			isLoading: false,
		}},

		mounted: function() {
			this.refreshThread();
		},

		methods: {

			getEntityReference: function() {
				return {entity: API.getEntityReference(this.entityType, this.entityId)}
			},

			refreshThread() {

				this.isLoading = true;

				axios.get(
					API.url(Endpoints.ActivityLog.FetchThread, this.getEntityReference()),
					API.headers()
				).then((res) => {
					this.isLoading = false;
					this.entries = res.data.entries;
				}).catch((err) => {
					this.isLoading = false;
					console.error("ActivityLogPanel -> failed to fetch thread: ", err);
				})

			},

		}

	}

</script>