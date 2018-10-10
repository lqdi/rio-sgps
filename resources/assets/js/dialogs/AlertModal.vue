<template>
	<modal :id="id" title="Atenção!" :visible="true" ref="modal">
		<strong slot="header">{{title || 'Atenção!'}}</strong>
		<div slot="body">
			<div class="form-group">
				<h5 class="text-center">{{message}}</h5>
			</div>

			<div class="form-group text-center">
				<button @click="close()" type="button" class="btn btn-primary">Fechar</button>
			</div>
		</div>
	</modal>
</template>

<script>
	export default {
		props: ['message', 'title'],

		data: () => { return {
			id: 'wndAlert_' + (new Date()).getTime(),
		}},

		mounted: function() {

		},

		methods: {
			close: function() {
				this.$close(true);
			},
		}
	}
</script>