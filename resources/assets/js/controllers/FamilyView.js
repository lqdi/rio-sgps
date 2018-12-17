import { create } from 'vue-modal-dialogs'
import AddFlagModal from '../modals/AddFlagModal';
import AssignUserModal from '../modals/AssignUserModal';
import ArchiveMemberModal from '../modals/ArchiveMemberModal';
import Dialogs from "../services/Dialogs";
import Endpoints from "../config/Endpoints";
import API from "../services/API";

const addFlag = create(AddFlagModal, 'family');
const assignUser = create(AssignUserModal, 'family');
const archiveMember = create(ArchiveMemberModal, 'familyId', 'memberId');

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

		archiveFamilyMember: async function(memberID) {
			let hasArchivedMember = await archiveMember(this.family.id, memberID);

			if(!hasArchivedMember) return;

			this.isLoading = true;
			location.reload();
		},

		cancelFlagAttribution: async function(entityType, entityID, flagID) {

			let shouldCancel = await Dialogs.confirm("Tem certeza que deseja cancelar essa etiqueta?");

			if(!shouldCancel) return;

			axios.post(
				API.url(Endpoints.Flags.Cancel, {entity: API.getEntityReference(entityType, entityID), flag_id: flagID}),
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

		completeFlagAttribution: async function(entityType, entityID, flagID) {

			let shouldCancel = await Dialogs.confirm("Tem certeza que deseja concluír essa etiqueta?");

			if(!shouldCancel) return;

			axios.post(
				API.url(Endpoints.Flags.Complete, {entity: API.getEntityReference(entityType, entityID), flag_id: flagID}),
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

		assignUser: async function() {
			let hasAssignedUser = await assignUser(this.family);

			if(!hasAssignedUser) return;

			this.isLoading = true;
			location.reload();
		},

		unassignUser: function(userID) {

			axios.post(
				API.url(Endpoints.Assignments.UnassignUserFromEntity, {entity: API.getEntityReference('family', this.family.id)}),
				{user_id: userID},
				API.headers()
			).then((res) => {
				this.isLoading = true;
				location.reload();
			}).catch((err) => {
				this.isLoading = false;
				console.error("FamilyView.unassignUser: ", err);
				Dialogs.alert('Ocorreu um erro ao salvar as informações!');
			});

		},

		addMemberToFamily: async function() {

			let memberName = await Dialogs.prompt('Digite o nome completo da pessoa', '', 'text', 'Nome completo...', 'Adicionando um novo membro');

			if(!memberName) return;

			axios.post(
				API.url(Endpoints.Family.AddMember, {id: this.family.id}),
				{member_name: memberName},
				API.headers()
			).then((res) => {
				this.isLoading = true;
				location.reload();
			}).catch((err) => {
				this.isLoading = false;
				console.error("FamilyView.addMemberToFamily: ", err);
				Dialogs.alert('Ocorreu um erro ao salvar as informações!');
			})

		}
	}
}