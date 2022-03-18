<template>
    <fragment>
        <a href="#" v-if="link===null" v-on:click="showModal(title, exchange)" data-bs-toggle="modal"
           data-bs-target="#withdrawActionSheet">
            <div v-if="icon==='withdraw'" class="icon-wrapper bg-danger">
                <ion-icon name="arrow-down-outline"></ion-icon>
            </div>
            <div v-if="icon==='send'" class="icon-wrapper">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </div>
            <div v-if="icon==='exchange'" class="icon-wrapper bg-warning">
                <ion-icon name="swap-vertical"></ion-icon>
            </div>
            <strong>{{ title }}</strong>
        </a>
        <a v-if="link!==null" :href=link>
            <div v-if="icon==='history'" class="icon-wrapper bg-success">
                <ion-icon name="card-outline"></ion-icon>
            </div>
            <strong>{{ title }}</strong>
        </a>
    </fragment>
</template>

<script>
import {eventBus} from "../../app";

export default {
    name: "StatisticAction",
    props: {
        icon: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        exchange: {
            type: Boolean,
            default: false
        },
        link: {
            type: String,
            default: null
        }
    },
    methods: {
        showModal(title, exchange) {
            eventBus.$emit('showModal', title, exchange)
        }
    }
}
</script>
