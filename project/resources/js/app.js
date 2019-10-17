import BootstrapVue from 'bootstrap-vue'


require('./bootstrap');

window.Vue = require('vue');


Vue.use(BootstrapVue)

Vue.component('data-list', require('./components/DataList.vue').default);

const app = new Vue({
    el: '#app',
});
