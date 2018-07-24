import WireframeCaseView from "./components/WireframeCaseView";

require('./bootstrap');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Vue = Vue;

Vue.use(BootstrapVue);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('tags-filter-modal', require('./components/TagsFilterModal.vue'));
Vue.component('wireframe-case-view', WireframeCaseView);

const app = new Vue({
    el: '#app'
});


