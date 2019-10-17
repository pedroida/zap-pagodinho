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
      showNextPagination() {
        return this.currentPage < this.lastPage;
      },

      showBackPagination() {
        this.currentPage > this.firstPage;
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
        firstPage: 1,
      }
    },

    methods: {
      fetchData() {
        axios.get(this.source).then((response) => {
          this.items = response.data.data;
        })
      }
    },
  }
</script>

<style scoped>

</style>