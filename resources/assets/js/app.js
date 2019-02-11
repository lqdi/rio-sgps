require('./bootstrap');

const moment = require('moment');
require('moment/locale/pt-br');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import * as ModalDialogs from 'vue-modal-dialogs';
import VueTheMask from 'vue-the-mask';
import Toasted from 'vue-toasted';
import Multiselect from 'vue-multiselect'

import 'bootstrap-vue/dist/bootstrap-vue.css'

import FamilyView from "./controllers/FamilyView";
import FamilySearch from "./controllers/FamilySearch";
import OperatorDashboard from "./controllers/OperatorDashboard";
import OperatorEdit from "./controllers/OperatorEdit";

window.Vue = Vue;


Vue.use(BootstrapVue);
Vue.use(require('vue-moment'), {moment});
Vue.use(ModalDialogs);
Vue.use(VueTheMask, {
	selectLabel: "ENTER para selecionar",
	deselectLabel: "ENTER para deselecionar",
	selectedLabel: "Selecionado",
});

Vue.use(Toasted, {
	position: 'bottom-right',
	duration: 5000,
	iconPack: 'fontawesome',
});

// Components
Vue.component('flag-display-tooltip', require('./components/FlagDisplayTooltip.vue'));
Vue.component('loading-feedback', require('./components/LoadingFeedback.vue'));
Vue.component('multiselect', require('./components/Multiselect.vue'));
Vue.component('dashboard-metrics', require('./components/DashboardMetrics.vue'));

// Panels
Vue.component('activity-log-panel', require('./panels/ActivityLogPanel.vue'));
Vue.component('comments-panel', require('./panels/CommentsPanel.vue'));
Vue.component('entity-questions-panel', require('./panels/EntityQuestionsPanel.vue'));

// Modals
Vue.component('modal', require('./modals/Modal.vue'));
Vue.component('alert-update-modal', require('./modals/AlertUpdateModal.vue'));
Vue.component('add-flag-modal', require('./modals/AddFlagModal.vue'));
Vue.component('assign-user-modal', require('./modals/AssignUserModal.vue'));
Vue.component('flags-filter-modal', require('./modals/FlagsFilterModal.vue'));
Vue.component('export-modal', require('./modals/ExportModal.vue'));

// Dialogs
Vue.component('alert-modal', require('./dialogs/AlertModal.vue'));
Vue.component('prompt-modal', require('./dialogs/PromptModal.vue'));
Vue.component('confirm-modal', require('./dialogs/ConfirmModal.vue'));

// Controllers
Vue.component('family-view', FamilyView);
Vue.component('family-search', FamilySearch);
Vue.component('operator-dashboard', OperatorDashboard);
Vue.component('operator-edit', OperatorEdit);


// Core app
const app = new Vue({
    el: '#app'
});
