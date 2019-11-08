<template>
  <div class="content chat-content">
    <div class="row">
      <chat-menu></chat-menu>

      <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card main-cards"></div>
      </div>
    </div>

  </div>
</template>

<script>
  import ChatMenu from './ChatMenu';

  export default {
    name: "chat-container",

    components: {
      ChatMenu,
    },

    props: {
      friendsUrl: String,
      newChatUrl: String,
      newChatsAvailableUrl: String,
    },

    created() {
      this.storeUrls();
    },

    methods: {
      storeUrls() {
        this.$store.commit('SET_FRIENDS_URL', this.friendsUrl);
        this.$store.commit('SET_NEW_CHAT_URL', this.newChatUrl);
        this.$store.commit('SET_NEW_CHATS_AVAILABLE_URL', this.newChatsAvailableUrl);
      }
    }
  }
</script>

<style scoped>

</style>

<style>
  .main-cards {
    height: 100%;
    margin-top: 0 !important;
  }
</style>