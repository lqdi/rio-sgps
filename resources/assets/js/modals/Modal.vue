<template>
	<div :id="id" class="modal-outer">
		<div class="modal sgps__modal fade show d-block">
			<div class="modal-dialog modal-md">
				<div tabindex="-1" role="document" class="modal-content">
					<header class="modal-header">
						<slot name="header"></slot>
						<button type="button" aria-label="Close" @click="close()" class="close">×</button>
					</header>
					<div class="modal-body">
						<slot name="body"></slot>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import {CLOSE_EVENT} from "vue-modal-dialogs/src/utils";

	export default {
		props: ['id'],
		methods: {
			close: function() {
				this.$emit(CLOSE_EVENT);
				if(!this.$parent) return;
				this.$parent.$emit(CLOSE_EVENT);
			}
		}
	}
</script>