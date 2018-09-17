<template>
	<div class="overlay" v-if="isLoading">
		<div class="loader-container">
			<pulse-loader class="loader" :loading="true" color="#666666" width="36px" height="12px"></pulse-loader>
		</div>
	</div>
</template>
<style scoped>
	.overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;

		width: 100%;
		height: 100%;

		z-index: 101000;

		background: rgba(255, 255, 255, 0.75);

	}

	@media (max-width: 480px) {
		.overlay {
			position: fixed;
			z-index: 8200;
		}
	}

	.loader-container {
		display: block;
		margin: 0 auto;
		height: 100%;

		vertical-align: middle;
		text-align: center;
	}

	.loader-container .loader {
		display: inline-block;
		margin-top: 100px;
		transform: translateY(50%);
	}
</style>
<script>

	export default {
		props: ['isLoading'],
		components: {
			pulseLoader: require('vue-spinner/src/PulseLoader.vue')
		}
	}
</script>