<script>
  export default {
    name: "data-list",

    template: '#data-list',

    props: {
      source: String,
    },

    mounted() {
      this.fetchData();
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
      query: _.debounce(function(text) {
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
      }
    },

    methods: {
      fetchData() {
        axios.get(this.fetchUrl).then((response) => {
          this.items = response.data.data;
          this.setPaginationData(response.data.meta);
          this.definePaginationButtons();
        })
      },

      setPaginationData(data) {
        this.perPage = data.per_page;
        this.lastPage = data.last_page;
        this.totalPages = data.last_page;
        this.currentPage = data.current_page;
      },

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

        if (endPage < totalPages){
          buttons.push({disabled: true, page: 0, text: '...'});
          buttons.push({disabled: false, page: totalPages, text: totalPages});
        }

        this.paginationButtons = buttons;
      },

      fetchPrevPage() {
        if (this.enabledPrevPageButton) {
          this.currentPage = this.currentPage - 1;
          this.fetchData();
        }
      },

      fetchNextPage() {
        if (this.enabledNextPageButton) {
          this.currentPage = this.currentPage + 1;
          this.fetchData();
        }
      },

      changePage(page) {
        this.currentPage = page;
        this.fetchData();
      },
    },
  }
</script>

<style scoped>

</style>