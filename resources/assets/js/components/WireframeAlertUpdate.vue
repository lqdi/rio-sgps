<template>
	<b-modal :id="id" ref="modal" v-model="isOpen" hide-footer title="Dar baixa em Alerta">
		<button @click="closeModal()" type="button" class="btn btn-block btn-success">Ficha de encaminhamento foi entregue</button>
		<button @click="closeModal()" type="button" class="btn btn-block btn-danger">Endereço não existe / Mudou-se</button>
		<button @click="closeModal()" type="button" class="btn btn-block btn-danger">Família não aceitou participar</button>
	</b-modal>
</template>

<script>
	export default {
		props: ['options', 'id'],

		data: () => { return {
			isOpen: false,
			selected: [],
		}},

		mounted: function() {

		},

		methods: {
			closeModal: function() {
				this.isOpen = false;
			}
		}
	}
</script>