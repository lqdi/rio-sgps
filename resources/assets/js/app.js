require('./bootstrap');

const moment = require('moment');
require('moment/locale/pt-br');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import * as ModalDialogs from 'vue-modal-dialogs';

import 'bootstrap-vue/dist/bootstrap-vue.css'

import FamilyView from "./controllers/FamilyView";

window.Vue = Vue;

Vue.use(BootstrapVue);
Vue.use(require('vue-moment'), {moment});
Vue.use(ModalDialogs);

// Components
Vue.component('flags-filter-modal', require('./components/FlagsFilterModal.vue'));
Vue.component('flag-display-tooltip', require('./components/FlagDisplayTooltip.vue'));
Vue.component('loading-feedback', require('./components/LoadingFeedback.vue'));

// Panels
Vue.component('comments-panel', require('./panels/CommentsPanel.vue'));
Vue.component('forms-panel', require('./panels/FormsPanel.vue'));

// Modals
Vue.component('modal', require('./modals/Modal.vue'));
Vue.component('alert-update-modal', require('./modals/AlertUpdateModal.vue'));
Vue.component('add-flag-modal', require('./modals/AddFlagModal.vue'));
Vue.component('assign-user-modal', require('./modals/AssignUserModal.vue'));

// Dialogs
Vue.component('alert-modal', require('./dialogs/AlertModal.vue'));
Vue.component('prompt-modal', require('./dialogs/PromptModal.vue'));
Vue.component('confirm-modal', require('./dialogs/ConfirmModal.vue'));

// Controllers
Vue.component('family-view', FamilyView);


// Core app
const app = new Vue({
    el: '#app'
});
