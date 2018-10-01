export default {
	data: () => { return {
		currentTab: 'overview',
		currentID: null,
		isFamilyOpen: false,
	}},

	mounted() {

	},

	methods: {
		isOpen: function(tab, id) {
			if(!id) return this.currentTab === tab;
			return this.currentTab === tab && this.currentID === id;
		},

		openTab: function(tab, id) {
			this.currentTab = tab;
			this.currentID = id;
		}
	}
}