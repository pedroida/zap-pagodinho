<template>
  <div class="col-lg-3 col-md-4 col-sm-12">
    <div class="card card-stats main-cards chat-menu-card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-10 col-10">
            <input type="text" placeholder="Buscar conversa" class="form-control" v-model="searchChat">
          </div>
          <div
              @click="showNewChatModal()"
              class="col-md-2 col-2 new-chat text-warning"
              data-toggle="popover"
              data-trigger="hover"
              data-title="Nova conversa"
              data-content="Converse com alguém pra tomar aquela prometida!">
            <i class="material-icons">chat</i>
          </div>
        </div>
      </div>
      <hr>
      <div @click="showChatList = !showChatList" class="card-body col-12 d-md-none d-sm-block toggle-show-list text-center">
        {{ showChatList ? 'Esconder' : 'Mostrar'}} chats <i class="fa" :class="showListIcon"></i>
      </div>
      <div v-show="showChatList" v-if="chats.length > 0" class="card-body chats-list">
        <div @click="openChat(chat)" v-for="(chat, index) in chats" :key="index" class="col-md-12 card chat-card">
          <p>{{ chat.friend_name }}</p>
            <small v-if="chat_last_message_type === 'text'">{{ chat.last_message }}</small>
            <small>
              <i class="fa fa-image mr-2"></i>
              imagem
            </small>

          <small>{{ chat.last_message_created_at }}</small>
        </div>
      </div>

      <div v-else class="card-body">
        <div class="col-12">
          <button
              @click="showNewChatModal()"
              class="btn btn-block btn-warning"
              data-toggle="popover"
              data-trigger="hover"
              data-title="Nova conversa"
              data-content="Converse com alguém pra tomar aquela prometida!">
            <i class="material-icons">chat</i>
            Nova conversa
          </button>
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
      const vm = this;
      this.fetchMyChats();

      this.listenJqueryEvents();

      this.$root.$on('remove-chat', (chatId) => this.chats = this.chats.filter((chat) => chat.id != chatId));

      this.$root.$on('update-chats-list', () => this.fetchMyChats());
      this.$root.$on('message-received', (message) => {
        let chat = this.chats.find((chat) => chat.id === message.chat_id);

        if (!chat) {
          this.fetchMyChats().then(() => {
            chat = this.chats.find((chat) => chat.id === message.chat_id);
          });
        }

        chat.last_message = message.content;
        chat.last_message_type = message.content_type;
        chat.last_message_created_at = message.created_at;

        this.chats.forEach(function (item, i) {
          if (item.id === message.chat_id) {
            vm.chats.splice(i, 1);
            vm.chats.unshift(item);
          }
        });
      });
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

      currentChat() {
        return this.$store.getters['getCurrentChat'];
      },

      showListIcon() {
        return (this.showChatList) ? 'fa-arrow-up' : 'fa-arrow-down';
      }
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
        showChatList: true,
      }
    },

    methods: {
      showNewChatModal() {
        this.$root.$emit('show-new-chat-modal');
      },

      fetchMyChats() {
        return axios.get(this.myChatSearchableUrl).then((response) => this.chats = response.data.data);
      },

      openChat(chat) {
        if (chat !== this.currentChat)
          this.$root.$emit('open-chat', chat);
      },

      listenJqueryEvents() {
        const vm = this;
        $(window).on('resize', function(){
          if (window.innerWidth >= 767) {
            vm.showChatList = true;
          }
        });
      },
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

  .toggle-show-list {
    cursor: pointer;
  }

  @media screen and (max-width: 767px){
    .chat-menu-card {
      height: auto;
    }
  }
</style>