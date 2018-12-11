<template>
	<vue-multiselect
			v-model="selectedObject"
			:multiple="multiple"
			:track-by="trackBy"
			:placeholder="placeholder"
			selectLabel="ENTER para selecionar"
			deselectLabel="ENTER para deselecionar"
			selectedLabel="Selecionado"
			:label="label"
			@input="onInput"
			:options="options"
			:id="id"
	></vue-multiselect>
</template>
<script>
	import Multiselect from 'vue-multiselect'

	export default {

		props: [
			'multiple',
			'value',
			'trackBy',
			'placeholder',
			'label',
			'options',
			'id',
		],

		components: {'vue-multiselect': Multiselect},

		data: () => { return {
			selectedObject: null,
		}},

		methods: {
			onInput: function (value, id) {
				this.$emit('input', value);
			}
		}

	}
</script>