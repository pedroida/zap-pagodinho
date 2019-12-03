<template>
  <div v-if="currentChat" class="col-md-12 p-0 chat">
    <div class="card">
      <div class="card-header msg_head">
        <div class="d-flex bd-highlight">
          <div class="img_cont">
            <img src="/material/img/beer-icon.png" class="rounded-circle user_img">
          </div>
          <div class="user_info">
            <span>
              {{ currentChat.name }}
              <small> ({{ totalMessages }} mensagens)</small>
            </span>
              <br>
              <small>
                Envolvidos: {{ currentChat.friends_name }}
              </small>
          </div>
        </div>
        <span @click="toggleActionMenu()" id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
        <div ref="action_menu" class="action_menu">
          <ul>
            <li v-if="currentChat.is_group" @click="leaveChat()"><i class="fa fa-sign-out"></i> Sair</li>
            <li @click="deleteChat()"><i class="fa fa-trash-o"></i> Apagar Conversa</li>
          </ul>
        </div>
      </div>

      <messages-data-list :source="currentSourcePagination"></messages-data-list>

      <div class="card-footer">
        <div class="input-group">
          <div class="input-group-append">
            <label class="input-group-text send_image_btn" for="send-image">
              <i class="fa fa-image"></i>
            </label>
            <input @change="uploadImage($event)" type="file" accept="image/*" id="send-image">
          </div>
          <input
              type="text"
              v-model="message"
              @keyup.enter="sendMessage()"
              class="form-control type_msg"
              placeholder="Escreva sua mensagem..."/>
          <div class="input-group-append" @click="sendMessage">
            <span class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="d-grid">
    <img class="m-auto" src="/material/img/zeca.jpg" alt="">
    <h4 class="text-center">
      Abra uma conversa aí meu consagrado
    </h4>
  </div>

</template>

<script>
  import MessagesDataList from './MessagesDataList';

  export default {
    name: "chat",

    components: {
      MessagesDataList,
    },

    mounted() {
      this.$root.$on('open-chat', (chat) => this.openChat(chat));
      this.$root.$on('update-total-messages', (totalMessages) => this.totalMessages = totalMessages);
      this.$root.$on('remove-chat', (chatId) => {
        if (this.currentChat.id == chatId)
          this.currentChat = undefined;
      });
    },

    computed: {
      currentSourcePagination() {
        return `pagination/chat/${this.currentChat.id}/messages`;
      },

      deleteChatUrl() {
        return this.$store.getters['getDeleteChatUrl'];
      },

      leaveChatUrl() {
        return this.$store.getters['getLeaveChatUrl'];
      },

      currentChat: {
        get() {
          return this.$store.getters['getCurrentChat'];
        },

        set(chat) {
          return this.$store.commit('SET_CURRENT_CHAT', chat);
        }
      },

      messages: {
        get() {
          return this.$store.getters['getMessages'];
        },

        set(messages) {
          return this.$store.commit('SET_MESSAGES', messages);
        }
      },

      sendMessageUrl() {
        return this.$store.getters['getSendMessageUrl'];
      }
    },

    data() {
      return {
        message: '',
        totalMessages: 0,
      }
    },

    methods: {
      uploadImage(event) {
        const vm = this;
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
          vm.sendImage(e.target.result);
        };
        reader.readAsDataURL(file);
      },

      toggleActionMenu() {
        $(this.$refs.action_menu).toggle();
      },

      deleteChat() {
        this.$swal({
          title: 'Certeza chegado?',
          text: "Não da pra voltar depois!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Apaga esse trem!'
        }).then((result) => {
          if (result.value) {
            axios.delete(this.deleteChatUrl.replace(':chat_id', this.currentChat.id))
              .then((response) => {
                this.$root.throwFlashMessage(response.data.type, response.data.message);
              })
          }
        })
      },

      leaveChat() {
        this.$swal({
          title: 'Certeza chegado?',
          text: "Não da pra voltar depois!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Me tira daqui!',
          cancelButtonText: 'Ficar-irei'
        }).then((result) => {
          if (result.value) {
            axios.post(this.leaveChatUrl.replace(':chat_id', this.currentChat.id))
              .then((response) => {
                this.$root.throwFlashMessage(response.data.type, response.data.message);
                this.$root.$emit('remove-current-chat-from-list');
              })
          }
        })
      },

      openChat(chat) {
        this.currentChat = chat;
        this.$root.$emit('change-chat-messages');
      },

      sendMessage() {
        if (!!this.message) {
          axios.post(this.sendMessageUrl, {
            message: this.message.trim(),
            chat_id: this.currentChat.id,
            type: 'text',
          }).then(() => this.message = '');
        }
      },

      sendImage(base64) {
        axios.post(this.sendMessageUrl, {
          message: base64,
          chat_id: this.currentChat.id,
          type: 'image',
        });
      }
    }
  }
</script>

<style scoped>
  .chat {
    margin-top: auto;
    margin-bottom: auto;
  }

  .card {
    margin: 0;
    background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQOcm7mhUW9UzqLwJJTHgwmTBq2QxNabHYFhmUJLEajfkpF2uCg");
  }

  .msg_card_body {
    overflow-y: auto;
  }

  .card-header {
    background-image: linear-gradient(orange, rgba(255, 165, 0, 0)) !important;
    border-radius: 6px 6px 0 0 !important;
    box-shadow: 0 3px 6px 0 #00000075;
  }

  .card-footer {
    border-radius: 0 0 6px 6px !important;
    border-top: 0 !important;
    margin: 0 !important;
    padding: 10px !important;
    box-shadow: 1px 1px 3px 1px #00000075;
    background-color: #cccccc;
  }

  .search {
    border-radius: 15px 0 0 15px !important;
    background-color: rgba(0, 0, 0, 0.3) !important;
    border: 0 !important;
    color: white !important;
  }

  .search:focus {
    box-shadow: none !important;
    outline: 0px !important;
  }

  .type_msg {
    background-color: white !important;
    border: 0 !important;
    height: 35px !important;
    overflow-y: auto;
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
    padding: 0 10px;
  }

  .type_msg:focus {
    box-shadow: none !important;
    outline: 0px !important;
  }

  .send_btn {
    border-radius: 0 15px 15px 0 !important;
    background-color: rgba(0, 0, 0, 0.3) !important;
    border: 0 !important;
    color: white !important;
    cursor: pointer;
  }
  .send_image_btn {
    border-radius: 15px 0 0 15px !important;
    background-color: rgba(0, 0, 0, 0.3) !important;
    border: 0 !important;
    color: white !important;
    cursor: pointer;
  }

  .search_btn {
    border-radius: 0 15px 15px 0 !important;
    background-color: rgba(0, 0, 0, 0.3) !important;
    border: 0 !important;
    color: white !important;
    cursor: pointer;
  }

  .user_img {
    height: 70px;
    width: 70px;
    border: 1.5px solid #f5f6fa;

  }

  .img_cont {
    position: relative;
    height: 70px;
    width: 70px;
  }

  .user_info {
    margin-left: 15px;
  }

  .user_info span {
    font-size: 20px;
    color: white;
    font-weight: bolder;
  }

  .user_info p {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.6);
  }

  .msg_head {
    position: relative;
  }

  #action_menu_btn {
    position: absolute;
    right: 10px;
    top: 10px;
    color: white;
    cursor: pointer;
    font-size: 20px;
  }

  .action_menu {
    z-index: 1;
    position: absolute;
    padding: 15px 0;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border-radius: 15px;
    top: 30px;
    right: 15px;
    display: none;
  }

  .action_menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .action_menu ul li {
    width: 100%;
    padding: 10px 15px;
    margin-bottom: 5px;
  }

  .action_menu ul li i {
    padding-right: 10px;

  }

  .action_menu ul li:hover {
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.2);
  }

  @media (max-width: 767px) {
    .chat {
      margin: 0;
      height: 100%;
    }
  }

  .d-grid {
    display: grid;
  }

  input[type='file'] {
    display: none
  }
</style>