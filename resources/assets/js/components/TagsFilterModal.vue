<template>
	<b-modal :id="id" ref="modal" v-model="isOpen" hide-footer title="Selecione as etiquetas para filtrar">
		<div class="justify-content-around">
			<b-form-checkbox-group v-model="selected" name="tags" :options="options"></b-form-checkbox-group>
		</div>
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

		}
	}
</script>