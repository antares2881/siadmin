require('./bootstrap');

window.Vue = require('vue');
import { BootstrapVue } from 'bootstrap-vue';

import { jsPDF } from "jspdf";
Vue.use(jsPDF);

Vue.use(BootstrapVue);

Vue.component('categoria-component', require('./components/CategoriaComponent.vue').default);
Vue.component('cliente-component', require('./components/ClienteComponent.vue').default);
Vue.component('compras-component', require('./components/CompraComponent.vue').default);
Vue.component('empresa-component', require('./components/EmpresaComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('inventario-component', require('./components/InventarioComponent.vue').default);
Vue.component('producto-component', require('./components/ProductoComponent.vue').default);
Vue.component('proveedores-component', require('./components/ProveedorComponent.vue').default);
Vue.component('usuarios-component', require('./components/UsuarioComponent.vue').default);
Vue.component('ventas-component', require('./components/VentaComponent.vue').default);

const app = new Vue({
    el: '#app',
});
