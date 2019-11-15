<template>
  <div class="modal fade bd-example-modal-lg" ref="newChatModal" tabindex="-1" role="dialog"
       aria-labelledby="myLargeModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Arme o gole</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table v-if="availableFriends.length > 0" class="table table-hover">
            <thead>
            <th>Nome</th>
            <th>Email</th>
            <th></th>
            </thead>
            <tbody>
            <tr v-for="(friend, index) in availableFriends">
              <td>{{ friend.name }}</td>
              <td>{{ friend.email }}</td>
              <td class="text-right">
                <button @click="startNewChat(friend)" class="btn btn-sm btn-success">
                  <i class="fa fa-plus"></i>
                  Começar um papo
                </button>
              </td>
            </tr>
            </tbody>
          </table>

          <div v-else class="text-center">
            <h4>
              Puts, tá sem amigos ou já conversa com todos.
            </h4>

            <a :href="friendsUrl" class="btn btn-primary text-white">
              Faça novas amizades
            </a>
          </div>
        </div>

        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-warning">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "new-chat-modal",

    mounted() {
      this.$root.$on('show-new-chat-modal', () => {
        this.handleShowModal();
      })
    },

    computed: {
      newChatAvailableUrl() {
        return this.$store.getters['getNewChatsAvailableUrl'];
      },

      getNewChatUrl() {
        return this.$store.getters['getNewChatUrl'];
      },

      friendsUrl() {
        return this.$store.getters['getFriendsUrl'];
      },
    },

    data() {
      return {
        availableFriends: [],
      }
    },

    methods: {
      handleShowModal() {
        axios.get(this.newChatAvailableUrl).then((response) => {
          this.availableFriends = response.data.data;
        }).finally(() => $(this.$refs.newChatModal).modal('toggle'));
      },

      startNewChat(friend) {
        axios.post(this.getNewChatUrl, {
          friend_id: friend.id,
        }).then((response) => {
          this.$root.$emit('update-chats-list');
          this.$root.$emit('open-chat', response.data);

          $(this.$refs.newChatModal).modal('toggle');
        })
      }
    }
  }
</script>

<style scoped>

</style>