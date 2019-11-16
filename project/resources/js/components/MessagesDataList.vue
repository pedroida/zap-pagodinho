<template>
  <div class="card-body msg_card_body">

    <div v-show="!loading"
        v-for="(item, index ) in items"
        :key="index"
        class="d-flex mb-4"
        :class="(item.is_my_message) ? 'justify-content-end' : 'justify-content-start'">
      <div :class="(item.is_my_message) ? 'msg_container_send' : 'msg_container'">
        {{ item.content }}
        <span :class="(item.is_my_message) ? 'msg_time_send' : 'msg_time'">{{ item.created_at }}</span>
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
      this.fetchData();

      this.$root.$on('change-chat-messages', () => {
        this.items = [];
        this.fetchData();
      })
    },

    computed: {
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

        loading: false,
      }
    },

    methods: {
      fetchData: _.debounce(function () {
        this.loading = true;
        axios.get(this.fetchUrl).then((response) => {
          let newMessages = response.data.data;
          newMessages = newMessages.concat(this.items);
          this.items = newMessages;

          this.setPaginationData(response.data.meta);
          this.definePaginationButtons();

          this.$root.$emit('update-total-messages', response.data.meta.total)
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
</style>