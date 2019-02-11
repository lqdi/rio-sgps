<template>

	<div class="row">

		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<div class="col-md-12 text-center" v-if="!isLoading && metricsToView.length <= 0">
			<div class="text-secondary">Não há nenhuma métrica no sistema associado à sua secretaria.</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_visits')">
			<div class="card metric" id="metric-qty_visits">
				<div class="card-header text-center">Domicílios visitados</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_visits}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_young_referred_to_smdei')">
			<div class="card metric" id="metric-qty_young_referred_to_smdei">
				<div class="card-header text-center">Jovens encaminhados para SMDEI (até 21 anos)</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_young_referred_to_smdei}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_adult_referred_to_smdei')">
			<div class="card metric" id="metric-qty_adult_referred_to_smdei">
				<div class="card-header text-center">Adultos encaminhados para SMDEI (maiores de 21 anos)</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_adult_referred_to_smdei}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_families_referred_to_cras')">
			<div class="card metric" id="metric-qty_families_referred_to_cras">
				<div class="card-header text-center">Famílias que chegaram ao CRAS</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_families_referred_to_cras}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_families_arrived_at_cras')">
			<div class="card metric" id="metric-qty_families_arrived_at_cras">
				<div class="card-header text-center">Famílias encaminhadas ao CRAS</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_families_arrived_at_cras}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_recipients_bf')">
			<div class="card metric" id="metric-qty_recipients_bf">
				<div class="card-header text-center">Famílias Beneficiárias do BF</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_recipients_bf}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_persons_without_documentation')">
			<div class="card metric" id="metric-qty_persons_without_documentation">
				<div class="card-header text-center">Indivíduos sem documentação</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_persons_without_documentation}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_persons_with_cadunico')">
			<div class="card metric" id="metric-qty_persons_with_cadunico">
				<div class="card-header text-center">Inscritos no CadÚnico</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_persons_with_cadunico}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_children_enrolled_at_ei')">
			<div class="card metric" id="metric-qty_children_enrolled_at_ei">
				<div class="card-header text-center">Crianças matriculadas no educação infantil (até 6 anos)</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_children_enrolled_at_ei}}</h3>
				</div>
			</div>
		</div>

		<div class="col-md-4 py-2" v-if="shouldShowMetric('qty_children_enrolled_at_ef')">
			<div class="card metric" id="metric-qty_children_enrolled_at_ef">
				<div class="card-header text-center">Crianças matriculadas no ensino fundamental (a partir de 6 anos)</div>
				<div class="card-body" v-if="metrics">
					<h3 class="text-center">{{metrics.qty_children_enrolled_at_ef}}</h3>
				</div>
			</div>
		</div>

	</div>

</template>
<script>
	import API from "../services/API";
	import Endpoints from "../config/Endpoints";
	import Dialogs from "../services/Dialogs";

	export default {

		data: () => { return {
			isLoading: false,
			metrics: null,
		}},

		props: ['metricsToView'],

		mounted: function() {
			this.refreshMetrics();
		},

		methods: {

			refreshMetrics: function() {
				this.isLoading = true;

				axios.get(
					API.url(Endpoints.Reports.AllMetrics),
					API.headers()
				).then(async (res) => {
					this.isLoading = false;
					this.metrics = res.data.metrics;
				}).catch((err) => {
					this.isLoading = false;
					Dialogs.alert('Ocorreu um erro ao carregar as métricas!');
				})
			},

			shouldShowMetric: function(metric) {
				if(!this.metricsToView) return false;
				return this.metricsToView.indexOf(metric) !== -1;
			},

		}

	}
</script>