require('./bootstrap');

window.Vue = require('vue');
import { BootstrapVue } from 'bootstrap-vue';

Vue.use(BootstrapVue);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('inventario-component', require('./components/InventarioComponent.vue').default);

const app = new Vue({
    el: '#app',
});
