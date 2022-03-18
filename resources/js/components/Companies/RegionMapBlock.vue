<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
               {{$trans('strings.Company address')}}
            </template>
        </Header>
        <div class="py-5">
            <yandex-map
                :coords="coords"
                :zoom="16"
                :settings="settings">
                <ymap-marker
                    marker-id="123"
                    :coords="coords"
                    :hint-content="this.company.title"
                    :balloon-template="balloonTemplate"
                />
            </yandex-map>
        </div>
    </fragment>
</template>

<script>
import {yandexMap, ymapMarker} from 'vue-yandex-maps'
import Header from "../LayoutComponents/Header";

export default {
    name: "RegionMapBlock",
    components: {Header, yandexMap, ymapMarker},
    props: {
        coords: {
            required: true
        },
        company: {
            required: true
        }
    },
    computed: {
        balloonTemplate() {
            return `
        <h3 class="red"> ${this.company.title}</h3>
        <img src="../assets/sample/${this.company.image}" alt="avatar" class="imaged w100 rounded">
      `
        }
    },
}
</script>

<style lang="scss">

.ymap-container {
    width: 100%;
    height: 100vh;
}
</style>
