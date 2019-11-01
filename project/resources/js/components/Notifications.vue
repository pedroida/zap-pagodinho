<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
      <i class="material-icons">{{ icon }}</i>
      <span class="notification">
        {{ notifications.length }}
      </span>
      <p class="d-lg-none d-md-block">
        BLA BLA
      </p>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
      <template v-if="hasNotifications">
        <a v-for="(notification, index) in notifications" :key="index" class="dropdown-item" href="#">
          <div>
          <span>
            Convite de: <strong>{{ notification.inviter_name }}</strong>
          </span>

            <br>

            <button @click="acceptInvite(notification.links.accept)" class="btn btn-sm btn-success">
              <i class="fa fa-check"></i>
            </button>

            <button @click="declineInvite(notification.links.decline)" class="btn btn-sm btn-danger">
              <i class="fa fa-close"></i>
            </button>
          </div>
        </a>
      </template>
      <a v-else href="#" class="dropdown-item">
        {{ emptyPhrase }}
      </a>
    </div>
  </li>
</template>

<script>
  export default {
    name: "notifications",

    props: {
      notificationsUrl: String,
      icon: String,
      emptyPhrase: {
        default: () => 'Nenhum item'
      }
    },

    mounted() {
      this.fetchNotifications();

      this.listenChannels();
    },

    computed: {
      hasNotifications() {
        return this.notifications.length > 0;
      }
    },

    data() {
      return {
        notifications: [],
      }
    },

    methods: {
      fetchNotifications() {
        axios.get(this.notificationsUrl).then((response) => {
          this.notifications = response.data.data;
        });
      },

      acceptInvite(url) {
        axios.post(url).then((response) => {
          this.$root.throwFlashMessage(response.data.type, response.data.message);
        }).finally(() => this.fetchNotifications());
      },

      declineInvite(url) {
        axios.post(url).then((response) => {
          this.$root.throwFlashMessage(response.data.type, response.data.message);
        }).finally(() => this.fetchNotifications());
      },

      listenChannels() {
        window.Echo.private(`user-notifications.${window.User}`)
          .listen('NewFriendshipInvite', (e) => {
            this.$root.throwFlashMessage('success', "Novo convite de amizade!");
            this.fetchNotifications()
          })
          .listen('FriendshipInviteAccepted', (e) => {
            this.$root.throwFlashMessage('success', e.name + " aceitou seu convite de amizade");
          })
          .listen('FriendshipInviteDeclined', (e) => {
            this.$root.throwFlashMessage('warning', e.name + " recusou seu convite de amizade");
          });
      }
    }
  }
</script>

<style scoped>
  .dropdown-toggle::after {
    content: unset;
  }
</style>