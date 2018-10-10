<template>
	<modal :id="id" ref="modal">
		<strong slot="header">{{title || 'Atenção!'}}</strong>
		<div slot="body">
			<div class="form-group">
				<h5 class="text-center">{{message}}</h5>
			</div>

			<div class="form-group text-center">
				<button @click="ok()" type="button" class="btn btn-primary">OK!</button>
				<button @click="cancel()" type="button" class="btn btn-secondary">Cancelar</button>
			</div>
		</div>
	</modal>
</template>

<script>
	export default {
		props: ['message', 'title'],

		data: () => { return {
			id: 'wndConfirm_' + (new Date()).getTime(),
		}},

		mounted: function() {

		},

		methods: {
			ok: function() {
				this.$close(true);
			},
			cancel: function() {
				this.$close(false);
			},
		}
	}
</script>