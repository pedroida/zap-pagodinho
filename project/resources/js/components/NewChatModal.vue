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
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Um chegado só</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Um grupo de pinguço</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              <div v-if="availableFriends.length > 0" class="col-12">
                <table class="table table-hover">
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
              </div>

              <div v-else class="text-center col-12">
                <h4>
                  Puts, tá sem amigos ou já conversa com todos.
                </h4>

                <a :href="friendsUrl" class="btn btn-primary text-white">
                  Faça novas amizades
                </a>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <div v-if="availableFriends.length > 0" class="col-12">
                <table class="table table-hover">
                  <thead>
                  <th></th>
                  <th>Nome</th>
                  <th>Email</th>
                  </thead>
                  <tbody>
                  <tr v-for="(friend, index) in availableFriends">
                    <td>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" :value="friend.id" v-model="groupFriends">
                          <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                        </label>
                      </div>
                    </td>
                    <td>{{ friend.name }}</td>
                    <td>{{ friend.email }}</td>
                  </tr>
                  </tbody>
                </table>

                <hr>

                <div class="row">
                  <div class="col-12 col-md-9">
                    <div class="form-group">
                      <input type="text" class="form-control" v-model="groupName" placeholder="Nome da bagunça">
                    </div>
                  </div>
                  <div class="col-12 col-md-3">
                    <button @click="startNewGroup()" class="btn btn-success">Criar grupo</button>
                  </div>
                </div>
              </div>

              <div v-else class="text-center col-12">
                <h4>
                  Puts, tá sem amigos ou já conversa com todos.
                </h4>

                <a :href="friendsUrl" class="btn btn-primary text-white">
                  Faça novas amizades
                </a>
              </div>
            </div>
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
        groupFriends: [],
        groupName: undefined,
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
          friend_id: [friend.id],
          is_group: false,
        }).then((response) => {
          this.$root.$emit('update-chats-list');
          this.$root.$emit('open-chat', response.data.data);

          $(this.$refs.newChatModal).modal('toggle');
        })
      },

      startNewGroup() {
        if (!this.groupName)
          return this.$root.throwFlashMessage('error', 'Coloca o nome do fervo chegado');

        if (this.groupFriends.length === 0)
          return this.$root.throwFlashMessage('error', 'Adiciona os pinguços aí');

        axios.post(this.getNewChatUrl, {
          friend_id: this.groupFriends,
          name: this.groupName,
          is_group: true,
        }).then((response) => {
          this.$root.$emit('update-chats-list');
          this.$root.$emit('open-chat', response.data.data);

          $(this.$refs.newChatModal).modal('toggle');
        })
      },
    }
  }
</script>

<style scoped>
  .nav-tabs .nav-link.active {
    border-color: #f08f00;
  }
</style>