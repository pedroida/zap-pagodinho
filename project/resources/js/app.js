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

Vue.component('loader', require('./components/Loader.vue').default);

const app = new Vue({
  el: '#app',

  store,

  mounted() {
    $(function () {
      $('[data-toggle="popover"]').popover()
    });

    if (window.User)
      this.listenChannels();
  },

  methods: {
    listenChannels() {
      window.Echo.private(`user-notifications.${window.User}`)
        .listen('NewFriendshipInvite', (e) => {
          this.$root.throwFlashMessage('success', "Novo convite de amizade!");
          this.$root.$emit('fetch-notifications');
        })
        .listen('FriendshipInviteAccepted', (e) => {
          this.$root.throwFlashMessage('success', e.name + " aceitou seu convite de amizade");
        })
        .listen('FriendshipInviteDeclined', (e) => {
          this.$root.throwFlashMessage('warning', e.name + " recusou seu convite de amizade");
        })
        .listen('ChatDestroyed', (e) => {
          this.$root.$emit('remove-chat', e.chat_id);
        })
        .notification((notification) => {
          if (notification.type === 'App\\Notifications\\NewMessageNotification')
            this.$root.$emit('message-received', notification.message);
        });

    },

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
