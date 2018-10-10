import { create } from 'vue-modal-dialogs'
import AddFlagModal from '../modals/AddFlagModal';
const addFlag = create(AddFlagModal, 'family');

export default {
	props: [
		'family',
	],

	data: () => { return {
		currentTab: 'overview',
		currentID: null,
		isLoading: false,
		isFamilyOpen: false,
	}},

	mounted: function() {
		if(!location.hash) return;

		let path = location.hash.substring(1).split('/');

		this.currentTab = path[0] || 'overview';
		this.currentID = path[1] || null;
	},

	methods: {
		isOpen: function(tab, id) {
			if(!id) return this.currentTab === tab;
			return this.currentTab === tab && this.currentID === id;
		},

		openTab: function(tab, id) {
			this.currentTab = tab;
			this.currentID = id;
		},

		addFlag: async function() {
			let hasAddedFlag = await addFlag(this.family);

			if(!hasAddedFlag) return;

			this.isLoading = true;
			location.reload();
		},
	}
}