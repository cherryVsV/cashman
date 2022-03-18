<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.newss')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section tab-content mt-2">
                <div class="row d-flex justify-content-center">
                    <div class="col-4 pl-6px"
                         v-for="item in news">
                        <NewsItem :item="item"></NewsItem>
                    </div>
                </div>
                <div>
                    <button :disabled='this.size >= items.length' href="javascript:;"
                            class="btn btn-block btn-primary btn-lg" @click="increaseSize">Load More
                    </button>
                </div>
            </div>
        </div>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import NewsItem from "../News/NewsItem";
import Header from "../LayoutComponents/Header";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";

export default {
    name: "NewsPage",
    components: {Footer, BottomMenu, NewsItem, Header},
    props: {
        items: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            page: 0,
            size: 12
        }
    },
    computed: {
        news() {
            const start = this.page * this.size,
                end = start + this.size;
            if (this.items.length > end) {
                return this.items.slice(start, end);
            }
            return this.items

        }
    },
    methods: {
        increaseSize() {
            this.size += this.size
        },
    }
}
</script>
