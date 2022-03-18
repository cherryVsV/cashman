<template>
    <fragment>
        <Header class="bg-primary text-light">
            <template v-slot:left>
                <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
                    <ion-icon name="menu-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                <img src="assets/logo.png" alt="logo" class="logo">
            </template>
            <template v-slot:right>
                <a href="/history" class="headerButton">
                    <ion-icon class="icon" name="notifications-outline"></ion-icon>
                    <span v-if="profile.notifications>0" class="badge badge-danger">{{profile.notifications}}</span>
                </a>
                <a href="/user-profile" class="headerButton">
                    <img :src="'assets/sample/' + profile.avatar" alt="image" class="imaged w32">
                </a>
            </template>
        </Header>
        <SideMenu :auth_user="auth_user"></SideMenu>
        <div id="appCapsule" class="full-height">
            <StatisticsSummary :profile="profile"></StatisticsSummary>
            <CompanyList :user="auth_user" :companies="companies"></CompanyList>
            <HistoryActionList v-if="actions.length>0" :show-detail="false" :actions="actions"></HistoryActionList>
            <AchievementList :show-detail="false"></AchievementList>
            <CashBackList v-if="cashbacks.length>0" :cashbacks="cashbacks"></CashBackList>
            <StoryList v-if="stories.length>0" :stories="stories"></StoryList>
            <ProductTile v-if="products.length>0" :items="products"></ProductTile>
            <UserList v-if="friends.length>0" :show-friends="true" :users="friends"></UserList>
            <NewsList v-if="news.length>0" :items="news"></NewsList>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import AchievementList from "../Achievements/AchievementList";
import UserList from "../Users/UserList";
import ProductTile from "../Products/ProductTile";
import CashBackList from "../CashBack/CashBackList";
import Footer from "../LayoutComponents/Footer";
import BottomMenu from "../LayoutComponents/BottomMenu";
import HistoryActionList from "../HistoryAction/HistoryActionList";
import StoryList from "../Stories/StoryList";
import StatisticsSummary from "../UserStatistic/StatisticsSummary";
import NewsList from "../News/NewsList";
import CompanyList from "../Companies/CompanyList/CompanyList";
import SideMenu from "../LayoutComponents/SideMenu";

export default {
    name: "UserPageComponent",
    components: {
        CompanyList, NewsList, StatisticsSummary, StoryList, HistoryActionList, BottomMenu, Footer, CashBackList,
        ProductTile, UserList, AchievementList, Header, SideMenu
    },
    props: {
        auth_user: {
            default: null
        },
        companies: {
            default: null
        },
        news: {
            required: true
        },
        stories: {
            required: true
        },
        cashbacks: {
            required: true
        },
        actions:{
            required: true
        }
    },
    data() {
        return {
            profile: [],
            products: [],
            friends: []
        }
    },
    methods: {
        getProfileData() {
            axios.get('api/profile/' + this.auth_user.id).then(response => {
                this.profile = response.data.profile
                this.friends = response.data.friends
            })
        },
        getProductsData() {
            axios.get('api/profile/products/' + this.auth_user.id).then(response => {
                this.products = response.data.products
            })
        }
    },
    mounted() {
        this.getProfileData()
        this.getProductsData()
    }
}
</script>
