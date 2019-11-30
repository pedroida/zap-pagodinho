<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle notifications-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
      <i class="material-icons">{{ icon }}</i>
      <span class="notification">
        {{ notifications.length }}
      </span>
      <p class="d-lg-none d-md-block">
        {{ (notifications.length > 1) ? 'convites' : 'convite' }} de amizade
      </p>
    </a>
    <div class="dropdown-menu dropdown-menu-right" id="notifications-list" aria-labelledby="navbarDropdownMenuLink">
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
      this.$root.$on('fetch-notifications', () => this.fetchNotifications());
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
    }
  }
</script>

<style scoped>
  .dropdown-toggle::after {
    content: unset;
  }

  @media screen and (max-width: 991px){
    .notifications-link {
      height: 58px;
    }

    .nav-item.dropdown.show > div {
      transform: translate3d(5px, 0, 0) !important;
    }

    .btn-sm {
      padding: 1rem;
    }

    .btn-sm i {
      margin-right: 0;
      padding: 10px 0;
      color: #ffffff;
    }

    #notifications-list.show {
      left: -196px !important;
      background: #ffffff;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
      position: absolute !important;
    }
  }
</style>