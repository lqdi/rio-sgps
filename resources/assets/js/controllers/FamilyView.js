import { create } from 'vue-modal-dialogs'
import AddFlagModal from '../modals/AddFlagModal';
import Dialogs from "../services/Dialogs";
import Endpoints from "../config/Endpoints";
import API from "../services/API";
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

		cancelFlagAssignment: async function(entityType, entityID, flagID) {

			let shouldCancel = await Dialogs.confirm("Tem certeza que deseja cancelar essa etiqueta?");

			if(!shouldCancel) return;

			axios.post(
				API.url(Endpoints.Flags.Cancel, {type: entityType, id: entityID, flag_id: flagID}),
				{},
				API.headers()
			).then(async (res) => {
				this.isLoading = false;
				await Dialogs.alert('A etiqueta foi cancelada com sucesso!');
				location.reload();
			}).catch((err) => {
				this.isLoading = false;
				Dialogs.alert('Ocorreu um erro ao cancelar a etiqueta!');
			})

		},

		completeFlagAssignment: async function(entityType, entityID, flagID) {

			let shouldCancel = await Dialogs.confirm("Tem certeza que deseja concluír essa etiqueta?");

			if(!shouldCancel) return;

			axios.post(
				API.url(Endpoints.Flags.Complete, {type: entityType, id: entityID, flag_id: flagID}),
				{},
				API.headers()
			).then(async (res) => {
				this.isLoading = false;
				await Dialogs.alert('A etiqueta foi concluída com sucesso!');
				location.reload();
			}).catch((err) => {
				this.isLoading = false;
				Dialogs.alert('Ocorreu um erro ao concluir a etiqueta!');
			})

		},

		addFlag: async function() {
			let hasAddedFlag = await addFlag(this.family);

			if(!hasAddedFlag) return;

			this.isLoading = true;
			location.reload();
		},
	}
}