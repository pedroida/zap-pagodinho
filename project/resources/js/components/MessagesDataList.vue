<template>
  <div id="chat_body" class="card-body msg_card_body">

    <div v-show="!loading"
        v-for="(item, index ) in items"
        :key="item.id"
        class="d-flex mb-4"
        :class="(item.user_id === userId) ? 'justify-content-end' : 'justify-content-start'">
      <div :class="(item.user_id === userId) ? 'msg_container_send' : 'msg_container'">
        <template v-if="item.content_type === 'text'">
          <template v-if="currentChat.is_group && item.user_id !== userId">
            <small>
              {{ item.user_name }}
            </small>
            <br>
          </template>
          {{ item.content }}
        </template>
        <img v-else :src="item.content" class="image-content" alt="">
        <span :class="(item.user_id === userId) ? 'msg_time_send' : 'msg_time'">{{ item.created_at }}</span>
      </div>
    </div>

    <loader :show-loader="loading"></loader>

  </div>
</template>
<script>
  export default {
    name: "messages-data-list",


    props: {
      source: String,
    },

    mounted() {
      const vm = this;
      this.fetchData();

      $(document).ready(function () {
        $('#chat_body').scroll((event) => {
          if ($(event.target).scrollTop() === 0) {
            vm.fetchNextPage();
          }
        });
      });

      this.$root.$on('change-chat-messages', () => {
        this.currentPage = 1;
        this.items = [];
        this.fetchData();
      });

      this.$root.$on('current-chat-insert-message', (message) => {
        this.totalMessages++;
        this.items.push(message)
      });
    },

    computed: {
      currentChat() {
        return this.$store.getters['getCurrentChat'];
      },

      userId() {
        return window.User;
      },

      enabledNextPageButton() {
        return this.currentPage < this.totalPages;
      },

      enabledPrevPageButton() {
        return this.currentPage > 1;
      },

      shouldShowPagination() {
        return this.totalPages > 1;
      },

      fetchUrl() {
        let query_params = '';
        query_params = '?query=' + this.query;
        query_params += '&field=' + this.field;

        if (this.currentPage != 1) {
          query_params += '&page=' + this.currentPage;
        }

        const url = this.source + query_params;
        return encodeURI(url);
      },

    },

    watch: {
      query: _.debounce(function (text) {
        this.currentPage = 1;
        this.fetchData();
      }, 350),

      items: _.debounce(function() {
        if (!this.keepChatOnTop) {
          let messageBody = document.getElementById("chat_body");
          messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
        }

        this.keepChatOnTop = false;
      }, 50),

      totalMessages() {
        this.$root.$emit('update-total-messages', this.totalMessages);
      }
    },

    data() {
      return {
        items: [],

        field: 'updated_at',
        order: 'desc',
        query: '',

        currentPage: 1,
        lastPage: 1,
        totalPages: 1,
        firstPage: 1,
        perPage: 20,
        paginationButtons: [],
        totalMessages: 0,
        loading: false,
        keepChatOnTop: false,
      }
    },

    methods: {
      fetchData: _.debounce(function () {
        this.loading = true;
        axios.get(this.fetchUrl).then((response) => {
          let newMessages = _.reverse(response.data.data);
          newMessages = newMessages.concat(this.items);
          this.items = newMessages;

          this.setPaginationData(response.data.meta);
          this.definePaginationButtons();

          this.totalMessages = response.data.meta.total;
        }).finally(() => this.loading = false)
      }, 100),

      setPaginationData(data) {
        this.perPage = data.per_page;
        this.lastPage = data.last_page;
        this.totalPages = data.last_page;
        this.currentPage = data.current_page;
      }
      ,

      definePaginationButtons() {
        const totalPages = this.totalPages;
        let startPage = this.currentPage - 4;
        let endPage = this.currentPage + 4;
        let buttons = [];

        if (startPage <= 0) {
          endPage -= (startPage - 1);
          startPage = 1;
        }

        if (endPage > totalPages)
          endPage = totalPages;

        if (startPage > 1) {
          buttons.push({disabled: false, page: 1, text: '1'});
          buttons.push({disabled: true, page: 0, text: '...'});
        }

        for (let i = startPage; i <= endPage; i++) {
          const active = (i == this.currentPage);
          buttons.push({disabled: false, page: i, text: i, active: active});
        }

        if (endPage < totalPages) {
          buttons.push({disabled: true, page: 0, text: '...'});
          buttons.push({disabled: false, page: totalPages, text: totalPages});
        }

        this.paginationButtons = buttons;
      }
      ,

      fetchPrevPage() {
        if (this.enabledPrevPageButton) {
          this.currentPage = this.currentPage - 1;
          this.fetchData();
        }
      }
      ,

      fetchNextPage() {
        if (this.enabledNextPageButton) {
          this.keepChatOnTop = true;
          this.currentPage = this.currentPage + 1;
          this.fetchData();
        }
      }
      ,

      changePage(page) {
        this.currentPage = page;
        this.fetchData();
      }
      ,
    },
  }
</script>

<style scoped>
  .msg_container {
    margin-top: auto;
    margin-bottom: auto;
    margin-left: 10px;
    border-radius: 25px;
    background-color: #82ccdd;
    padding: 10px;
    position: relative;
  }

  .msg_container_send {
    margin-top: auto;
    margin-bottom: auto;
    margin-right: 10px;
    border-radius: 25px;
    background-color: #78e08f;
    padding: 10px;
    position: relative;
  }

  .msg_time {
    position: absolute;
    left: 15px;
    bottom: -20px;
    color: black;
    font-size: 10px;
    min-width: 100px;
    text-align: left;
  }

  .msg_time_send {
    position: absolute;
    right: 15px;
    bottom: -20px;
    color: black;
    font-size: 10px;
    min-width: 100px;
    text-align: right;
  }

  /* width */
  ::-webkit-scrollbar {
    width: 10px;
    border-radius: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  .image-content {
    max-width: 150px;
    max-height: 150px;
  }
</style>