<template>
    <fragment>
        <Header class="bg-primary text-light">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:right v-if="admins.length>0 || isAdmin || user!==null">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            id="dropdownSelectCompany" aria-expanded="false">
                     {{$trans('strings.Actions')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownSelectCompany">
                        <li>
                            <a v-if="admins.length>0" class="dropdown-item" href="#" @click="showAdminsModal">{{$trans('strings.Administrators')}}</a>
                        </li>
                        <li>
                            <a v-if="user!==null" :href="'/promo-code/'+user.id + '/' + company.id"
                               class="dropdown-item">{{$trans('strings.Invite a friend')}}</a>
                        </li>
                        <li>
                            <a v-if="user!==null" :href="'/friends-tree/'+ company.id" class="dropdown-item">{{$trans('strings.Tree of Friends')}}</a>
                        </li>
                    </ul>
                </div>

                <button v-if="isAdmin && isActive!==null && isActive" @click="changeActiveAdmin" type="button"
                        class="btn btn-inline btn-danger me-1" style="width: 50px">
                    Offline
                </button>
                <button v-if="isAdmin && isActive!==null && !isActive" @click="changeActiveAdmin" type="button"
                        class="btn btn-inline btn-success me-1" style="width: 50px">
                    Online
                </button>
            </template>
        </Header>
        <div id="appCapsule" class="full-height">

            <div class="section mt-2">
                <div class="profile-head">
                    <div class="avatar">
                        <img :src="'assets/sample/'+company.image" alt="avatar" class="imaged w64 rounded">
                    </div>
                    <div class="in">
                        <h2>{{ company.title }}</h2>
                    </div>
                </div>
            </div>

            <div class="section full mt-2">
                <div class="profile-stats pl-2 pr-2">
                    <a href="#" class="item">
                        <strong>{{ products.length }}</strong>{{$trans('strings.products')}}
                    </a>
                    <a href="#" class="item">
                        <strong>{{ users.length }}</strong>{{$trans('strings.users')}}

                    </a>
                    <a href="#" class="item">
                        <strong>{{ stories.length }}</strong>{{$trans('strings.stories')}}

                    </a>

                    <a href="#" class="item">
                        <strong>{{ news.length }}</strong>{{$trans('strings.news')}}

                    </a>
                </div>
            </div>

            <div class="section mt-1 mb-2">
                <div class="profile-info">
                    <div class="bio subtext">
                        <h3 v-if="company.description">{{$trans('strings.About us:')}}</h3>
                        <h5 v-if="company.description">{{ company.description }}</h5>
                        <h3 v-if="company.properties.time">{{$trans('strings.Working hours:')}}</h3>
                        <h4 v-if="company.properties.time">{{ company.properties.time }}</h4>
                        <h3 v-if="typeof(company.properties.address)!=='string' && company.properties.address">{{$trans('strings.Our addresses:')}}</h3>
                        <div v-if="typeof(company.properties.address)!=='string'&& company.properties.address"
                             v-for="address in company.properties.address">
                            <h4> {{ address }}</h4>
                        </div>
                        <h3 v-if="typeof(company.properties.address)==='string' && company.properties.address">{{$trans('strings.Our address:')}}</h3>
                        <h4 v-if="typeof(company.properties.address)==='string' && company.properties.address">
                            {{ company.properties.address }}</h4>
                        <div v-for="(property, key) in company.properties">
                            <h4 v-if="key !== 'address' && key !== 'time'"> {{ property }}</h4>

                        </div>
                    </div>
                    <div class="link" v-if="company.socials">
                        <h3>{{$trans('strings.Social network')}}</h3>
                        <ul class="listview image-listview no-line no-space flush">
                            <li v-for="(social, key) in company.socials">
                                <div class="item" v-if="social!==null">
                                    <div class="icon-box bg-primary">
                                        <i :class="'fab fa-'+key"></i>
                                    </div>
                                    <div class="in">
                                        <div class="input-wrapper w-100">
                                            <a :href="social"
                                               target="_blank"><label>{{ $trans('strings.Link to the profile in') + key }}</label></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section mt-1 mb-2">
                <h3>{{$trans('strings.Promo code of the user in the company')}}</h3>
                <div class="splash-page mt-5 mb-5">
                    <div class="d-flex">
                        <vue-qrcode :value=code :options="{ width: 200 }"></vue-qrcode>
                    </div>
                </div>
            </div>
            <StoryList :add-new="isAdmin && company.story" :stories="stories"></StoryList>
            <br/>
            <div class="section full">
                <div class="wide-block transparent p-0">
                    <ul class="nav nav-tabs lined iconed" role="tablist">
                        <li v-if="news.length>0" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#feed" role="tab">
                                <ion-icon name="grid-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="news.length===0  && users.length>0" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#friends" role="tab">
                                <ion-icon name="people-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="news.length>0  && users.length>0" class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#friends" role="tab">
                                <ion-icon name="people-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="products.length>0 && users.length>0" class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#bookmarks" role="tab">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="products.length>0 && users.length===0  && users.length>0" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#bookmarks" role="tab">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="isAdmin && users.length>0" class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                                <ion-icon name="settings-outline"></ion-icon>
                            </a>
                        </li>
                        <li v-if="isAdmin && users.length===0" class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#settings" role="tab">
                                <ion-icon name="settings-outline"></ion-icon>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- tab content -->
            <div class="section full mb-2">
                <div class="tab-content">

                    <!-- feed -->
                    <div v-if="news.length>0" class="tab-pane fade show active" id="feed" role="tabpanel">
                        <div class="mt-2 pr-2 pl-2">
                            <div class="row">
                                <div class="col-4 pl-6px" v-for="item in paginatedData">
                                    <NewsItem :item="item"></NewsItem>
                                </div>

                            </div>
                        </div>

                        <div v-if="isAdmin" class="row" style="margin-left: 4px; margin-right: 5px">
                            <div class="col-6">
                                <button :disabled='sizeNews >= news.length' :href="'#'"
                                        class="btn btn-outline-primary btn-block"
                                        @click="increaseSize">{{$trans('strings.More news')}}
                                </button>
                            </div>
                            <div class="col-6" v-if="company.news">
                                <a :href="'/add-advertising-'+this.company.id" class="btn btn-primary btn-block">{{$trans('strings.Add')}}</a>
                            </div>
                        </div>
                        <div v-if="!isAdmin" class="pr-2 pl-2">
                            <button :disabled='sizeNews >= news.length' href="#" class="btn btn-primary btn-block"
                                    @click="increaseSize">{{$trans('strings.More news')}}
                            </button>
                        </div>
                    </div>
                    <!-- * feed -->

                    <!-- * friends -->
                    <div v-if="news.length===0 && users.length>0 " class="tab-pane fade show active" id="friend"
                         role="tabpanel">
                        <ul class="listview image-listview flush transparent pt-1">
                            <li v-for="user in users">
                                <FriendItem :user="user"></FriendItem>
                            </li>

                        </ul>
                    </div>
                    <div v-if="this.news.length>0 && users.length>0" class="tab-pane fade" id="friends" role="tabpanel">
                        <ul class="listview image-listview flush transparent pt-1">
                            <li v-for="user in users">
                                <FriendItem :user="user"></FriendItem>
                            </li>

                        </ul>
                    </div>
                    <!-- * friends -->

                    <!--  bookmarks -->
                    <div v-if="this.products.length>0" class="tab-pane fade" id="bookmarks" role="tabpanel">
                        <div class="section mt-1 row">
                            <div class="col-4 pl-6px mb-2" v-for="product in companyProducts">
                                <ProductItem :items="product" :action="!isAdmin"></ProductItem>
                            </div>
                        </div>
                        <div v-if="isAdmin" class="row" style="margin-left: 4px; margin-right: 5px">
                            <div class="col-6">
                                <button :disabled='this.sizeProduct >= products.length' :href="'#'"
                                        class="btn btn-outline-primary btn-block" @click="increaseProductSize">{{$trans('strings.More products')}}
                                </button>
                            </div>
                            <div class="col-6">
                                <a :href="'#'" class="btn  btn-primary btn-block">{{$trans('strings.Add')}}</a>
                            </div>
                        </div>
                        <div v-if="!isAdmin" class="pr-2 pl-2">
                            <button :disabled='this.sizeProduct >= products.length' href="#"
                                    class="btn btn-primary btn-block" @click="increaseProductSize">{{$trans('strings.More products')}}
                            </button>
                        </div>
                    </div>
                    <!-- * bookmarks -->
                    <!-- settings -->
                    <div v-if="isAdmin" class="tab-pane fade" id="settings" role="tabpanel">
                        <ul class="listview image-listview text flush transparent pt-1">
                            <li>
                                <a :href="'/company-edit-'+company.id" class="item">
                                    <div class="in">
                                        <div class="text-danger">{{$trans('strings.Company Profile Settings')}}</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a :href="'/company-admin-menu-'+company.id" class="item">
                                    <div class="in">
                                        <div class="text-danger">{{$trans('strings.Company Admin menu')}}</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="item">
                                    <div class="in">
                                        <div>{{$trans('strings.Accrual/write-off history')}}</div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a :href="'/company-tariffs-'+company.id" class="item">
                                    <div class="in">
                                        <div>{{$trans('strings.Tariffs and plans')}}</div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- * settings -->
                </div>
            </div>
            <!-- * tab content -->
        </div>
        <BottomMenu></BottomMenu>
        <ShowAdminsModal :admins="admins"></ShowAdminsModal>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import Footer from "../LayoutComponents/Footer";
import BottomMenu from "../LayoutComponents/BottomMenu";
import StoryList from "../Stories/StoryList";
import NewsItem from "../News/NewsItem";
import FriendItem from "../Users/FriendItem";
import ProductItem from "../Products/ProductItem";
import ProductTile from "../Products/ProductTile";
import ShowAdminsModal from "../Modals/ShowAdminsModal";
import VueQrcode from '@chenfengyuan/vue-qrcode';

export default {
    name: "CompanyProfile",
    components: {
        ShowAdminsModal,
        ProductTile,
        ProductItem,
        FriendItem,
        NewsItem,
        StoryList,
        BottomMenu,
        Footer,
        Header,
        VueQrcode
    },
    props: {
        company: {
            type: Object,
            required: true
        },
        news: {
            required: true
        },
        stories: {
            required: true
        },
        users: {
            required: true
        },
        isAdmin: {
            type: Boolean,
            default: false
        },
        user: {
            type: Object,
            default: null
        }

    },

    data: function () {
        return {
            code: [],
            pageNews: 0,
            pageProducts: 0,
            sizeProduct: 9,
            sizeNews: 6,
            isActive: null,
            admins: [],
            product: []
        }
    },
    mounted() {
        document.querySelector('body').classList.add('bg-white');
        if (this.user !== null) {
            this.isActive = this.user.isActive
        }
        axios.get('api/active/admins/company/' + this.company.id).then((response) => {
            this.admins = response.data.admins
            this.products = response.data.products
        })
        axios.get('api/qrcode/' + this.user.id + '/' + this.company.id).then((response) => {
            this.code = response.data.code
        })
    },
    computed: {

        paginatedData() {
            const start = this.pageNews * this.sizeNews,
                end = start + this.sizeNews;
            if (this.news.length > end) {
                return this.news.slice(start, end);
            }
            return this.news
        },
        companyProducts() {
            const start = this.pageProducts * this.sizeProduct,
                end = start + this.sizeProduct;
            if (this.products.length > end) {
                return this.products.slice(start, end);
            }
            return this.products

        }
    },
    methods: {
        increaseSize() {
            this.size += this.size
        },
        increaseProductSize() {
            this.sizeProduct += this.sizeProduct
        },
        changeActiveAdmin() {
            axios.get('api/change/active-admin/' + this.user.id + '/' + this.company.id)
            this.isActive = !this.isActive
            axios.get('api/active/admins/company/' + this.company.id).then((response) => {
                this.admins = response.data.admins
            })
        },
        showAdminsModal() {
            axios.get('api/active/admins/company/' + this.company.id).then((response) => {
                this.admins = response.data.admins
            })
            $('#ShowAdmins').modal('show');
        }
    }

}
</script>

<style scoped>

</style>
