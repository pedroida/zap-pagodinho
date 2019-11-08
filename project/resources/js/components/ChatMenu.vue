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
      <div class="card-body">

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

    data() {
      return {
        searchChat: undefined,
      }
    },

    methods: {
      showNewChatModal() {
        this.$root.$emit('show-new-chat-modal');
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
</style>