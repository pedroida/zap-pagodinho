<template>
  <div v-if="currentChat" class="col-md-12 p-0 chat">
    <div class="card">
      <div class="card-header msg_head">
        <div class="d-flex bd-highlight">
          <div class="img_cont">
            <img src="/material/img/beer-icon.png" class="rounded-circle user_img">
            <span class="online_icon"></span>
          </div>
          <div class="user_info">
            <span>{{ currentChat.friend_name }}</span>
            <p>{{ totalMessages }} mensagens</p>
          </div>
        </div>
        <span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
        <div class="action_menu">
          <ul>
            <li><i class="fas fa-user-circle"></i> View profile</li>
            <li><i class="fas fa-users"></i> Add to close friends</li>
            <li><i class="fas fa-plus"></i> Add to group</li>
            <li><i class="fas fa-ban"></i> Block</li>
          </ul>
        </div>
      </div>

      <messages-data-list :source="currentSourcePagination"></messages-data-list>

      <div class="card-footer">
        <div class="input-group">
          <textarea v-model="message" name="" class="form-control type_msg" placeholder="Escreva sua mensagem..."></textarea>
          <div class="input-group-append">
            <span class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h2 v-else class="text-center">
    Abra uma conversa aqui do lado meu consagrado
  </h2>

</template>

<script>
  import MessagesDataList from './MessagesDataList';
  export default {
    name: "chat",

    components: {
      MessagesDataList,
    },

    mounted() {
      $(document).ready(function(){
        $('#action_menu_btn').click(function(){
          $('.action_menu').toggle();
        });
      });

      this.$root.$on('open-chat', (chat) => this.openChat(chat));
      this.$root.$on('update-total-messages', (totalMessages) => this.totalMessages = totalMessages);
    },

    computed: {
      currentSourcePagination() {
        return `pagination/chat/${this.currentChat.id}/messages`;
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
    },

    data() {
      return {
        message: '',
        totalMessages: 0,
      }
    },

    methods: {
      openChat(chat) {
        this.currentChat = chat;
        this.$root.$emit('change-chat-messages');
      }
    }
  }
</script>

<style scoped>
  .chat{
    margin-top: auto;
    margin-bottom: auto;
  }
  .card{
    margin: 0;
    background-image: linear-gradient(orange, rgba(255, 165, 0, 0.52)) !important;
  }

  .msg_card_body{
    overflow-y: auto;
  }
  .card-header{
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 0 !important;
  }
  .card-footer{
    border-radius: 0 0 15px 15px !important;
    border-top: 0 !important;
  }

  .search{
    border-radius: 15px 0 0 15px !important;
    background-color: rgba(0,0,0,0.3) !important;
    border:0 !important;
    color:white !important;
  }
  .search:focus{
    box-shadow:none !important;
    outline:0px !important;
  }
  .type_msg{
    background-color: white !important;
    border:0 !important;
    height: 35px !important;
    overflow-y: auto;
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
  }
  .type_msg:focus{
    box-shadow:none !important;
    outline:0px !important;
  }

  .send_btn{
    border-radius: 0 15px 15px 0 !important;
    background-color: rgba(0,0,0,0.3) !important;
    border:0 !important;
    color: white !important;
    cursor: pointer;
  }
  .search_btn{
    border-radius: 0 15px 15px 0 !important;
    background-color: rgba(0,0,0,0.3) !important;
    border:0 !important;
    color: white !important;
    cursor: pointer;
  }
  .contacts{
    list-style: none;
    padding: 0;
  }
  .contacts li{
    width: 100% !important;
    padding: 5px 10px;
    margin-bottom: 15px !important;
  }
  .active{
    background-color: rgba(0,0,0,0.3);
  }
  .user_img{
    height: 70px;
    width: 70px;
    border:1.5px solid #f5f6fa;

  }
  .user_img_msg{
    height: 40px;
    width: 40px;
    border:1.5px solid #f5f6fa;

  }
  .img_cont{
    position: relative;
    height: 70px;
    width: 70px;
  }
  .img_cont_msg{
    height: 40px;
    width: 40px;
  }
  .online_icon{
    position: absolute;
    height: 15px;
    width:15px;
    background-color: #4cd137;
    border-radius: 50%;
    bottom: 0.2em;
    right: 0.4em;
    border:1.5px solid white;
  }
  .offline{
    background-color: #c23616 !important;
  }
  .user_info{
    margin-top: auto;
    margin-bottom: auto;
    margin-left: 15px;
  }
  .user_info span{
    font-size: 20px;
    color: white;
  }
  .user_info p{
    font-size: 10px;
    color: rgba(255,255,255,0.6);
  }
  .video_cam{
    margin-left: 50px;
    margin-top: 5px;
  }
  .video_cam span{
    color: white;
    font-size: 20px;
    cursor: pointer;
    margin-right: 20px;
  }

  .msg_head{
    position: relative;
  }
  #action_menu_btn{
    position: absolute;
    right: 10px;
    top: 10px;
    color: white;
    cursor: pointer;
    font-size: 20px;
  }
  .action_menu{
    z-index: 1;
    position: absolute;
    padding: 15px 0;
    background-color: rgba(0,0,0,0.5);
    color: white;
    border-radius: 15px;
    top: 30px;
    right: 15px;
    display: none;
  }
  .action_menu ul{
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .action_menu ul li{
    width: 100%;
    padding: 10px 15px;
    margin-bottom: 5px;
  }
  .action_menu ul li i{
    padding-right: 10px;

  }
  .action_menu ul li:hover{
    cursor: pointer;
    background-color: rgba(0,0,0,0.2);
  }
  @media(max-width: 576px){
    .contacts_card{
      margin-bottom: 15px !important;
    }
  }
</style>