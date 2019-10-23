import VueSweetalert2 from 'vue-sweetalert2';

require('./bootstrap');

window.Vue = require('vue');

const options = {
  confirmButtonColor: '#41b882',
  cancelButtonColor: '#ff7674',
};

Vue.use(VueSweetalert2, options);

Vue.component('data-list', require('./components/DataList.vue').default);

Vue.component('new-friend-modal', require('./components/NewFriend.vue').default);

Vue.component('notifications', require('./components/Notifications.vue').default);

const app = new Vue({
  el: '#app',

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
