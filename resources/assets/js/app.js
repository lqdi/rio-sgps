require('./bootstrap');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap-vue/dist/bootstrap-vue.css'

import FamilyView from "./controllers/FamilyView";

window.Vue = Vue;

Vue.use(BootstrapVue);

// Components
Vue.component('flags-filter-modal', require('./components/FlagsFilterModal.vue'));
Vue.component('flag-display-tooltip', require('./components/FlagDisplayTooltip.vue'));
Vue.component('loading-feedback', require('./components/LoadingFeedback.vue'));

// Panels
Vue.component('comments-panel', require('./panels/CommentsPanel.vue'));
Vue.component('forms-panel', require('./panels/FormsPanel.vue'));

// Modals
Vue.component('alert-update-modal', require('./modals/AlertUpdateModal.vue'));

// Controllers
Vue.component('family-view', FamilyView);


// Core app
const app = new Vue({
    el: '#app'
});
