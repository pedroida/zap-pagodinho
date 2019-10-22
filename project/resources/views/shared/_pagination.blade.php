<div class="text-center col">
    <div class="custom-pagination" v-if="shouldShowPagination">
        <div class="row">
            <div class="col">
                <button
                        type="button"
                        class="btn btn-outline-secondary "
                        @click="fetchPrevPage"
                        :disabled="!enabledPrevPageButton">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                    Anterior
                </button>
            </div>
            <div class="col">
                <button
                        type="button"
                        :ref="'paginationButton' + button.page"
                        class="btn btn-light"
                        v-for="button in paginationButtons"
                        :class="{'active': button.active, 'disabled': button.disabled}"
                        @click="changePage(button.page)">
                    @{{button.text}}
                </button>
            </div>

            <div class="col">
                <button class="btn btn-outline-secondary "
                        type="button"
                        :disabled="!enabledNextPageButton"
                        @click="fetchNextPage" >
                    Próxima
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
