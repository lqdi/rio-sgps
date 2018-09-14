<template>
	<b-modal :id="id" ref="modal" v-model="isOpen" hide-footer title="Selecione as etiquetas para filtrar">
		<div class="justify-content-around">
			<b-form-checkbox-group v-model="selected" name="tags" :options="options"></b-form-checkbox-group>
		</div>
	</b-modal>
</template>

<script>
	export default {
		props: ['flags', 'id'],

		data: () => { return {
			isOpen: false,
			selected: [],
			options: [],
		}},

		mounted: function() {
			this.options = this.flags.map((option) => {
				return {
					text: option.name,
					value: option.id
				}
			})
		},

		methods: {

		}
	}
</script>