<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{ item.title }}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2">
                <h1>
                    {{ item.title }}
                </h1>
                <div class="blog-header-info mt-2 mb-2">
                    <div>
                        <img :src="'./../assets/sample/'+company.image" alt="img" class="imaged w24 rounded me-05">
                        by {{ company.title }}
                    </div>
                    <div>
                        {{ item.created_at | myDate }}
                    </div>
                </div>
            </div>
            <div class="section mt-2">
                <figure>
                    <img :src="'./../assets/sample/'+item.images.main" alt="image" class="imaged img-fluid">
                </figure>
                <p>
                    {{ item.description }}
                </p>
            </div>
            <div class="section">
                <button class="btn btn-block btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#actionSheetShare"
                        @click="shareProduct()">
                    <ion-icon name="share-outline"></ion-icon>
                    {{$trans('strings.Share This Post')}}
                </button>
            </div>
            <div class="section mt-3">
                <h2>{{$trans('strings.Related Posts')}}</h2>
                <div class="row mt-3">
                    <div class="col-6 mb-2" v-for="item in items">
                        <NewsItem :item="item"></NewsItem>
                    </div>
                </div>
            </div>
        </div>
        <BottomMenu></BottomMenu>
        <ShareModal></ShareModal>
    </fragment>
</template>

<script>
import ShareModal from "../Modals/ShareModal";
import NewsItem from "./NewsItem";
import Header from "../LayoutComponents/Header";
import BottomMenu from "../LayoutComponents/BottomMenu";
import {eventBus} from "../../app";

export default {
    name: "NewsDetail",
    components: {BottomMenu, NewsItem, ShareModal, Header},
    props: {
        item: {
            type: Object,
            required: true
        },
        items: {
            type: Object,
            required: true
        },
        company: {
            type: Object,
            required: true
        }
    },
    methods: {
        shareProduct(){
            eventBus.$emit('share-product', location.href)
        }
    }

}
</script>
