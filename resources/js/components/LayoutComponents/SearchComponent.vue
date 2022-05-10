<template>
    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input v-model="query" type="text" class="form-control" placeholder="Поиск...">
                <i class="input-icon icon ion-ios-search" @click="searchCompanies" @keyup.enter="searchCompanies"></i>
                <a href="#" class="ms-1 close toggle-searchbox" @click="clear">
                    <i class="icon ion-ios-close-circle"></i>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->
</template>

<script>
export default {
    name: "SearchComponent",
    data() {
        return {
            query: '',
        }
    },
    watch: {
        query: {
            handler: _.debounce(function () {
                this.searchCompanies()
            }, 100)
        }
    },
    methods: {
        searchCompanies() {
            this.$store.dispatch('SEARCH_COMPANIES', this.query)
        },
        clear(){
            this.query = ''
        }
    }
}
</script>
