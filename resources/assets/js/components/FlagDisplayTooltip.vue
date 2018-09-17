<template>
	<div>
		<span v-for="flag in visibleFlags" :class="[getColorClass(flag)]" class="badge badge-light mr-1">{{flag.name}}</span>
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

			getColorClass(flag) {

				switch(flag.entity_type) {
					case 'family': return 'text-primary';
					case 'residence': return 'text-success';
					case 'person': return 'text-info';
					default: return 'text-default';
				}

			},

			buildPopoverHTML() {
				return this.flags.map((flag) => '&bull; ' + flag.name).join('<br />')
			}

		}

	}
</script>