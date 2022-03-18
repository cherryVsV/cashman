<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Activity history')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <ActivityHistoryList :actions="history" :all="false"></ActivityHistoryList>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>

import BottomMenu from "../LayoutComponents/BottomMenu";
import Header from "../LayoutComponents/Header";
import ActivityHistoryList from "./ActivityHistoryList";

export default {
    name: "ActivityHistoryPage",
    components: {ActivityHistoryList, BottomMenu, Header},
    props: {
        history: {
            required: true
        }
    }
}
</script>

<style scoped>

</style>
