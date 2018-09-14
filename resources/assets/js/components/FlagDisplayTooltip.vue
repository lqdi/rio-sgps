<template>
	<div>
		<span v-for="flag in visibleFlags" class="badge badge-secondary mr-1">{{flag.name}}</span>
		<span v-if="flags.length > 2" class="badge badge-primary" v-b-popover.hover="flagsPopover" title="Etiquetas aplicadas">+ {{flags.length - 2}}</span>
	</div>
</template>
<script>
	export default {

		props: ['flags'],

		data: () => { return {
			visibleFlags: [],
			flagsPopover: {}
		}},

		mounted: function() {

			this.visibleFlags = this.flags.slice(0, 2);
			this.flagsPopover = {
				content: this.buildPopoverHTML(),
				html: true
			};

		},

		methods: {

			buildPopoverHTML() {
				return this.flags.map((flag) => '&bull; ' + flag.name).join('<br />')
			}

		}

	}
</script>