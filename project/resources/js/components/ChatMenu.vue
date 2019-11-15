<template>
  <div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card card-stats main-cards">
      <div class="card-header">
        <div class="row">
          <div class="col-md-10">
            <input type="text" placeholder="Buscar conversa" class="form-control" v-model="searchChat">
          </div>
          <div
              @click="showNewChatModal()"
              class="col-md-2 new-chat text-warning"
              data-toggle="popover"
              data-trigger="hover"
              data-title="Nova conversa"
              data-content="Converse com alguém pra tomar aquela prometida!">
            <i class="material-icons">chat</i>
          </div>
        </div>
      </div>
      <hr>
      <div class="card-body chats-list">
        <div v-for="(chat, index) in chats" :key="index" class="col-md-12 card chat-card">
          <p>{{ chat.friend_name }}</p>
          <small>{{ chat.last_message }}</small>
        </div>
      </div>
    </div>

    <new-chat-modal></new-chat-modal>

  </div>
</template>

<script>
  import NewChatModal from './NewChatModal';

  export default {
    name: "chat-menu",

    components: {
      NewChatModal,
    },

    mounted() {
      this.fetchMyChats();

      this.$root.$on('update-chats-list', () => this.fetchMyChats());
    },

    computed: {
      myChatsUrl() {
        return this.$store.getters['getMyChatsUrl'];
      },

      myChatSearchableUrl() {
        if (this.searchChat)
          return this.myChatsUrl + '?friend_name=' + this.searchChat;

        return this.myChatsUrl;
      },
    },

    watch: {
      searchChat() {
        this.fetchMyChats();
      }
    },

    data() {
      return {
        searchChat: undefined,
        chats: [],
      }
    },

    methods: {
      showNewChatModal() {
        this.$root.$emit('show-new-chat-modal');
      },

      fetchMyChats() {
        console.log('fetch');
        return axios.get(this.myChatSearchableUrl).then((response) => this.chats = response.data.data);
      }
    }
  }
</script>

<style scoped>
  .new-chat {
    display: flex;
    align-items: center;
    cursor: pointer;
  }

  .chat-card {
    cursor: pointer;
    text-align: left;
    margin: 0 0 10px 0 !important;
    background-color: #ff9800;
    color: white;
  }

  .chat-card:hover {
    margin: 0 0 10px 0 !important;
    background-color: white;
    color: #ff9800;
  }

  .chats-list {
    overflow-y: auto;
  }
</style>