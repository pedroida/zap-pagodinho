<template>
  <div class="col-12">
    <button type="button" @click="toggleModal" class="btn btn-sm btn-primary float-right">
      {{ newFriendButton }}
    </button>
    <div class="modal fade bd-example-modal-lg" ref="newFriendModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Faça novas amizades</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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
                    <button @click="sendInvite(friend.links.send_invite)" class="btn btn-sm btn-success">
                      <i class="fa fa-plus"></i>
                      Enviar convite de amizade
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>
          </div>

          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-warning">Fechar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "new-friend",

    props: {
      availableFriendsListUrl: String,
      newFriendButton: String,
    },

    mounted() {
      this.fetchAvailableFriends();
    },

    data() {
      return {
        availableFriends: [],
      }
    },

    methods: {
      fetchAvailableFriends() {
        axios.get(this.availableFriendsListUrl).then((response) => {
          this.availableFriends = response.data.data;
        });
      },

      sendInvite(url) {
        axios.post(url).then((response) => {
          this.$root.throwFlashMessage(response.data.type, response.data.message);
        }).catch((error) => this.$root.throwFlashMessage('error', 'Houve uma treta pra adicionar o chegado'))
          .finally(() =>  this.fetchAvailableFriends());
      },

      toggleModal() {
        $(this.$refs.newFriendModal).modal('toggle');
      }
    }
  }
</script>

<style scoped>

</style>