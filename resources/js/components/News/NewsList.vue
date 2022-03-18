<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 class="title">{{$trans('strings.Latest news')}}</h2>
            <a href="news" class="link">{{$trans('strings.View all')}}</a>
        </div>
        <splide :slides="items" :options="options">
            <splide-slide v-for="item in items" :key="item.id">
                <NewsItem :item="item"></NewsItem>
            </splide-slide>
        </splide>
    </div>
</template>

<script>
import NewsItem from "./NewsItem";
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "NewsList",
    components: {NewsItem, Splide, SplideSlide},
    props: {
        items: {
            type: Array,
            required: true
        }
    },
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
                        perPage: 2,
                    },
                    600: {
                        perPage: 2,
                    },
                    768: {
                        perPage: 3,
                    },
                    1024: {
                        perPage: 4,
                    },
                    1440: {
                        perPage: 5,
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
        };
    }
}
</script>
