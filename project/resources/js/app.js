import VueSweetalert2 from 'vue-sweetalert2';
import Vuex from 'vuex';
import Store from './components/store';

require('./bootstrap');

window.Vue = require('vue');

const options = {
  confirmButtonColor: '#41b882',
  cancelButtonColor: '#ff7674',
};

Vue.use(Vuex);

const store = new Vuex.Store(Store);

Vue.use(VueSweetalert2, options);

Vue.component('data-list', require('./components/DataList.vue').default);

Vue.component('new-friend-modal', require('./components/NewFriend.vue').default);

Vue.component('notifications', require('./components/Notifications.vue').default);

Vue.component('chat-container', require('./components/ChatContainer.vue').default);

const app = new Vue({
  el: '#app',

  store,

  mounted() {
    $(function () {
      $('[data-toggle="popover"]').popover()
    })
  },

  methods: {
    throwFlashMessage(type, message) {
      this.$swal({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: type,
        text: message,
      });
    },
  }
});
