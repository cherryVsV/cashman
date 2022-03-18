<template>
    <div class="section mt-4" id="splide-slider">
        <div class="section-heading padding">
            <h2 class="title">{{$trans('strings.Companies')}}</h2>
            <a href="/search-company" class="link">{{$trans('strings.View all')}}</a>
        </div>
        <splide :slides="companies" :options="options" :key="trigger">
            <splide-slide v-for="company in companies" :key="company.id">
                <CompanyItem :company="company" :user="user"></CompanyItem>
            </splide-slide>
        </splide>

        <h4 class="text-center" v-if="companies.length===0">{{$trans("You haven't registered with any company yet. Click \"View All\" to display a list of companies")}}</h4>
        <!-- * carousel single -->
    </div>
</template>

<script>
import CompanyItem from "./CompanyItem";
import {Splide, SplideSlide} from '@splidejs/vue-splide';
import {eventBus} from '../../../app'

export default {
    name: "CompanyList",
    components: {CompanyItem, Splide, SplideSlide},
    data() {
        return {
            options: {
                perPage: 10,
                rewind: true,
                gap: 16,
                padding: 16,
                arrows: false,
                pagination: false,
                cover: true,
                lazyLoad: 'sequential',
                breakpoints: {
                    320: {
                        perPage: 2,
                    },
                    375: {
                        perPage: 2,
                    },
                    425: {
                        perPage: 3,
                    },
                    600: {
                        perPage: 3,
                    },
                    768: {
                        perPage: 4,
                    },
                    1024: {
                        perPage: 5,
                    },
                    1440: {
                        perPage: 6,
                    },
                    1600: {
                        perPage: 6,
                    },
                    1680: {
                        perPage: 6,
                    },
                    1920: {
                        perPage: 8,
                    },
                    2500: {
                        perPage: 10,
                    },
                }
            },
            trigger: 0
        }
    },
    props: {
        user: {
            default: null
        },
        companies: {
            type: Array
        }
    },
    methods: {
        updateCompanies(number) {
            this.trigger += number
        }
    },
    mounted() {
        eventBus.$on('updateCompanies', this.updateCompanies)
    },


}
</script>
