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
                <a v-if="auth_user===null" href="/login" class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="log-in-outline"></ion-icon>
                    </div>
                </a>
                <a v-if="auth_user!==null" href="/history" class="headerButton">
                    <ion-icon class="icon" name="notifications-outline"></ion-icon>
                    <span v-if="profile.notifications>0" class="badge badge-danger">{{profile.notifications}}</span>
                </a>
                <a v-if="auth_user!==null" href="/user-profile" class="headerButton">
                    <img :src="'assets/sample/' + profile.avatar" alt="image" class="imaged w32">
                </a>
            </template>
        </Header>
        <SideMenu :auth_user="auth_user"></SideMenu>
        <div id="appCapsule" class="full-height">
            <ActivityHistoryList v-if="history.length>0" :actions="history"></ActivityHistoryList>
            <StoryList v-if="stories.length>0" :stories="stories"></StoryList>
            <ProductTile v-if="products.length>0" :items="products"></ProductTile>
            <NewsList v-if="news.length>0" :items="news"></NewsList>
            <CompanyList v-if="companies.length>0" :companies="companies" :user="auth_user"></CompanyList>
            <UserList v-if="users.length>0" :show-friends="false" :users="users"></UserList>
            <CallbackForm></CallbackForm>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";
import CallbackForm from "../Callback/CallbackForm";
import ProductTile from "../Products/ProductTile";
import StoryList from "../Stories/StoryList";
import ActivityHistoryList from "../ActivityHistory/ActivityHistoryList";
import UserList from "../Users/UserList";
import NewsList from "../News/NewsList";
import CompanyList from "../Companies/CompanyList/CompanyList";
import SideMenu from "../LayoutComponents/SideMenu";
import LangSwitcher from "../LayoutComponents/LangSwitcher";

export default {
    name: "MainPageComponent",
    components: {
        LangSwitcher,
        CompanyList,
        NewsList,
        UserList,
        ActivityHistoryList,
        StoryList,
        ProductTile,
        CallbackForm,
        Footer,
        BottomMenu,
        Header,
        SideMenu
    },
    props: {
        auth_user: {
            default: null
        }
    },
    data() {
        return {
            companies: [],
            products: [],
            news: [],
            stories: [],
            profile: [],
            history: [],
            users: []
        }
    },
    mounted() {
        this.getCompaniesByCoords()
        this.getProfileData()
    },
    methods: {
        getCompaniesByCoords() {
            let vm = this
            navigator.geolocation.getCurrentPosition(
                position => {
                    console.log(position)
                    axios.post('api/sort/companies', {
                        lat: position.coords.latitude,
                        lon: position.coords.longitude
                    })
                        .then(function (response) {
                            vm.companies = response.data.companies
                            vm.products = response.data.products
                            vm.news = response.data.news
                            vm.stories = response.data.stories
                            vm.history = response.data.history
                            vm.users = response.data.users
                        })
                },
                error => {
                    axios.post('api/sort/companies', {
                        lat: 0,
                        lon: 0
                    })
                        .then(function (response) {
                            vm.companies = response.data.companies
                            vm.products = response.data.products
                            vm.news = response.data.news
                            vm.stories = response.data.stories
                        })
                },
            )

        },
        getProfileData() {
            if(this.auth_user!==null) {
                axios.get('api/profile/' + this.auth_user.id).then(response => {
                    this.profile = response.data.profile
                })
            }
        }
    }
}

</script>
<style>
.section-heading {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

@media (max-width: 375px) {
    .section-heading .title {
        font-size: 90%;
    }

    .section-heading .link {
        font-size: 90%;
    }

}
</style>
