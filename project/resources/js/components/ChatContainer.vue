<template>
  <div class="content chat-content">
    <div class="row">
      <chat-menu></chat-menu>

      <div class="col-lg-9 col-md-8 col-sm-12">
        <div class="card main-cards chat">

          <chat></chat>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import ChatMenu from './ChatMenu';
  import Chat from './Chat';

  export default {
    name: "chat-container",

    components: {
      ChatMenu,
      Chat,
    },

    props: {
      friendsUrl: String,
      newChatUrl: String,
      myChatsUrl: String,
      deleteChatUrl: String,
      leaveChatUrl: String,
      sendMessageUrl: String,
      newChatsAvailableUrl: String,
    },

    created() {
      this.storeUrls();

      this.$root.$on('message-received', (message) => {
        if (this.currentChat && message.chat_id === this.currentChat.id) {
          this.$root.$emit('current-chat-insert-message', message);
        }
      })
    },

    computed: {
      currentChat() {
        return this.$store.getters['getCurrentChat'];
      }
    },

    methods: {
      storeUrls() {
        this.$store.commit('SET_FRIENDS_URL', this.friendsUrl);
        this.$store.commit('SET_MY_CHATS_URL', this.myChatsUrl);
        this.$store.commit('SET_NEW_CHAT_URL', this.newChatUrl);
        this.$store.commit('SET_DELETE_CHAT_URL', this.deleteChatUrl);
        this.$store.commit('SET_LEAVE_CHAT_URL', this.leaveChatUrl);
        this.$store.commit('SET_SEND_MESSAGE_URL', this.sendMessageUrl);
        this.$store.commit('SET_NEW_CHATS_AVAILABLE_URL', this.newChatsAvailableUrl);
      }
    }
  }
</script>

<style scoped>

</style>

<style>
  .main-cards {
    height: 79vh;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  .chat {
    display: flex;
    justify-content: center;
  }
</style>