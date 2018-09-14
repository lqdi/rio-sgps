require('./bootstrap');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import WireframeCaseView from "./components/WireframeCaseView";
import WireframeAlertUpdate from "./components/WireframeAlertUpdate";

window.Vue = Vue;

Vue.use(BootstrapVue);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('flags-filter-modal', require('./components/FlagsFilterModal.vue'));
Vue.component('flag-display-tooltip', require('./components/FlagDisplayTooltip.vue'));
Vue.component('wireframe-case-view', WireframeCaseView);
Vue.component('wireframe-alert-update', WireframeAlertUpdate);

const app = new Vue({
    el: '#app'
});


