<template>
    <fragment>
        <Header id="companies">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Companies')}}
            </template>
            <template v-slot:right>
                <a href="javascript:;" class="headerButton toggle-searchbox">
                    <ion-icon name="search-outline"></ion-icon>
                </a>
            </template>
        </Header>
        <SearchComponent></SearchComponent>
        <div id="appCapsule" class="full-height">
            <div class="section tab-content mt-2 mb-2" :key="trigger">
                <div class="row d-flex justify-content-center">
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3 col-xxl-2 mb-2"
                         v-for="company in paginatedData">
                        <CompanyItem :company="company" :user="auth_user"></CompanyItem>
                    </div>
                </div>
            </div>
            <nav>
                <ul class="pagination pagination-rounded">
                    <li>
                        <button class="page-link" @click="prevPage" :disabled="pageNumber===0" type="button">
                            {{$trans('strings.Previous')}}
                        </button>
                    </li>
                    <li class="disabled ">
                        <a class="page-link" style="background: #fff !important;color: #6236FF !important;">
                            {{$trans('strings.Page')}} {{ pageNumber + 1 }} {{$trans('strings.from')}} {{ pageCount }}
                        </a>
                    </li>
                    <li>
                        <button class="page-link" @click="nextPage" :disabled="pageNumber >= pageCount-1" type="button">
                            {{$trans('strings.Next')}}
                        </button>
                    </li>
                </ul>
            </nav>

        </div>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import CompanyItem from "./CompanyList/CompanyItem";
import SearchComponent from "../LayoutComponents/SearchComponent";
import BottomMenu from "../LayoutComponents/BottomMenu";
import {mapGetters} from 'vuex'
import {eventBus} from '../../app'

export default {
    name: "SearchCompanySection",
    components: {BottomMenu, SearchComponent, CompanyItem, Header},
    data: function () {
        return {
            pageNumber: 0,
            size: 12,
            trigger: 0

        }
    },
    methods: {
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        },
        updateCompanies(number) {
            this.trigger += number
        }

    },
    props: {
        auth_user: {
            default: null
        }
    },

    mounted() {
        this.$store.dispatch('GET_COMPANIES')

        window.Echo.channel('search')
            .listen('.searchResults', (e) => {
                this.$store.commit('SET_COMPANIES', e.companies)
            })
        eventBus.$on('updateCompanies', this.updateCompanies)
    },
    computed: {
        groupedCompanies() {
            return this.companies;
        },
        ...mapGetters([
            'companies'
        ]),
        pageCount() {
            let l = this.groupedCompanies.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;
            return this.groupedCompanies.slice(start, end);
        },

    }
}
</script>

<style scoped>
.pagination {
    justify-content: center;
}

.page-link {
    background: #6236FF !important;
    color: #fff !important;
}

@media (max-width: 375px) {
    .page-link {
        font-size: 70%;
    }
}
</style>
