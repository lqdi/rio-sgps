export default {

	data: () => { return {
		selectedGroups: null,
	}},

	props: ['initiallySelectedGroups'],

	mounted: function() {
		this.selectedGroups = this.initiallySelectedGroups || [];
	},

	methods: {

		hasSelectedGroup: function(groupCode) {
			if(!this.selectedGroups) return false;
			return this.selectedGroups.indexOf(groupCode) !== -1;
		},

		onGroupsUpdate: function(groupCode, $event) {

			if(!$event.target.checked) {
				this.selectedGroups = this.selectedGroups.filter((code) => code !== groupCode);
			} else {
				this.selectedGroups.push(groupCode);
				this.$forceUpdate();
			}

			console.log(this.selectedGroups);
		}

	}

}