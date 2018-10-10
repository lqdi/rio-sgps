<template>
	<modal :id="id" ref="modal">
		<strong slot="header">{{title || 'Atenção!'}}</strong>
		<form slot="body" @submit.prevent="ok()">

			<div class="form-group">
				<h5 class="text-center">{{message}}</h5>
			</div>

			<div class="form-group">
				<input autofocus class="form-control form-control-lg" v-model="value" :type="type" :placeholder="placeholder" />
			</div>

			<div class="form-control text-center">
				<button type="submit" class="btn btn-primary">OK</button>
				<button @click="cancel()" type="button" class="btn btn-secondary">Cancelar</button>
			</div>
		</form>
	</modal>
</template>

<script>
	export default {
		props: ['message', 'initialValue', 'type', 'placeholder', 'title'],

		data: () => { return {
			value: '',
			id: 'wndPrompt_' + (new Date()).getTime(),
		}},

		mounted: function() {
			if(!this.initialValue) return;
			this.value = this.initialValue;
		},

		methods: {
			ok: function() {
				this.$close(this.value);
			},
			cancel: function() {
				this.$close(false);
			},
		}
	}
</script>