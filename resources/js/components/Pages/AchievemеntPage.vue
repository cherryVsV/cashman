<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Achievements')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <AchievementList :show-detail="true" :achievements="achievements"></AchievementList>
        </div>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import AchievementList from "../Achievements/AchievementList";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";

export default {
    name: "AchievementPage",
    components: {Footer, BottomMenu, AchievementList, Header},
    props: ['achievements']
}
</script>
