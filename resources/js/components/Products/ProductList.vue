<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{ $trans('strings.Stocks') }}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-4">
                <div class="section-heading padding">
                    <h2 class="title">{{ $trans('strings.Categories') }}</h2>
                </div>
                <div class="mb-0 categories-block splide">
                    <splide :slides="categories" :options="options">
                        <splide-slide v-for="(category, index) in categories" :key="category.id">
                            <a href="#" @click="sortProducts(category, index)" v-scroll-to="'#products'"
                               :class="{ tagActive: index===currentIndex}">
                                {{ category.title }}
                                <span :class="{ tagActive: index===currentIndex}"
                                      class="badge badge-primary">{{ category.number }}</span>
                            </a>
                        </splide-slide>
                    </splide>
                </div>
            </div>
            <StoryList :stories="stories"></StoryList>
            <div class="section mt-4" :key="trigger">
                <div class="section-heading padding">
                    <h2 v-if="currentCategory===''" class="title">{{ $trans('strings.Stocks') }}</h2>
                    <h2 v-if="currentCategory!==''" class="title" id="products">
                        {{ $trans('strings.Promotions from the category') }} {{currentCategory}}
                    </h2>
                </div>
                <div class="section tab-content mt-2 mb-1">
                    <!-- waiting tab -->
                    <div class="tab-pane fade show active" id="waiting" role="tabpanel">
                        <div class="row d-flex justify-content-center">
                            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3 col-xxl-2 mb-2"
                                 v-for="item in paginatedProducts">
                                <ProductItem :items=item></ProductItem>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button :disabled='this.size >= items.length' href="javascript:;"
                            class="btn btn-block btn-primary btn-lg" @click="increaseSize">
                        {{ $trans('strings.Load More') }}
                    </button>
                </div>
            </div>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import ProductItem from "./ProductItem";
import Header from "../LayoutComponents/Header";
import StoryList from "../Stories/StoryList";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "ProductList",
    components: {Footer, StoryList, ProductItem, Header, BottomMenu, Splide, SplideSlide},
    data: function () {
        return {
            items: [],
            categories: [],
            stories: [],
            page: 0,
            size: 12,
            trigger: 0,
            currentCategory: '',
            options: {
                rewind: true,
                gap: 16,
                padding: 16,
                arrows: false,
                pagination: false,
                cover: true,
                autoWidth: true,
                lazyLoad: 'sequential'
            },
            isActive: false,
            currentIndex: -1
        }
    },
    methods: {
        getProductsAndCategories() {
            let vm = this
            axios.get('api/products')
                .then(response => {
                    vm.items = response.data.products
                    vm.categories = response.data.categories
                    vm.stories = response.data.stories

                })
        },
        sortProducts(category, index) {
            this.currentIndex = index
            this.isActive = (this.isActive !== true)
            axios.get('products/category/' + category.id).then(response => {
                this.items = response.data.products
                this.currentCategory = category.title
                this.trigger++
            })
        },
        increaseSize() {
            this.size += this.size
        },
    },
    mounted() {
        this.getProductsAndCategories();
    },
    computed: {
        paginatedProducts() {
            const start = this.page * this.size,
                end = start + this.size;
            if (this.items.length > end) {
                return this.items.slice(start, end);
            }
            return this.items

        }
    },
}
</script>
<style>
.tagActive {
    border-radius: 100px;
    padding: 0 6px;
    display: inline-flex;
    align-items: center;
    background: #6236FF !important;
    color: white !important;
}
</style>
