<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 class="title">{{ $trans('strings.Stocks') }}</h2>
            <a href="products" class="link">{{ $trans('strings.View all') }}</a>
        </div>
        <!-- carousel multiple -->
        <splide :slides="items" :options="options">
            <splide-slide v-for="item in items" :key="item.id">
                <ProductItem :items=item></ProductItem>
            </splide-slide>
        </splide>

        <!-- * carousel multiple -->
    </div>
</template>

<script>
import ProductItem from "./ProductItem";
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "ProductTile",
    components: {ProductItem, Splide, SplideSlide},
    props: {
        items: {
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
        };
    },
}
</script>
