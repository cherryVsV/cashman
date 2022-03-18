<template>
    <fragment>
        <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <!-- logo -->
                        <div v-if="auth_user===null" class="profileBox pt-2 pb-2 bg-primary">
                            <div class="image-wrapper">
                                <img src="assets/logo.png" alt="image" class="w-100">
                            </div>
                        </div>
                        <!-- profile box -->
                        <div v-if="auth_user!==null" class="profileBox pt-2 pb-2">
                            <div class="image-wrapper">
                                <img :src="'assets/sample/'+profile.avatar" alt="image" class="imaged  w36">
                            </div>
                            <div class="in">
                                <h3>{{profile.name}}</h3>
                                <div class="text-muted">{{auth_user.id}}</div>
                            </div>
                            <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </div>
                        <!-- * profile box -->
                        <!-- balance -->
                        <div v-if="auth_user!==null" class="sidebar-balance">
                            <div class="listview-title">Balance</div>
                            <div class="in">
                                <h1 class="amount">$ {{profile.score}}</h1>
                            </div>
                        </div>
                        <!-- * balance -->

                        <!-- action group -->
                        <div v-if="auth_user!==null" class="action-group">
                            <a href="#" class="action-button" data-bs-toggle="modal"
                               data-bs-target="#depositActionSheet">
                                <div class="in">
                                    <div class="iconbox">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                  {{$trans('strings.Add')}}
                                </div>
                            </a>
                            <a href="#" class="action-button" data-bs-toggle="modal"
                               data-bs-target="#withdrawActionSheet1">
                                <div class="in">
                                    <div class="iconbox">
                                        <ion-icon name="arrow-down-outline"></ion-icon>
                                    </div>
                                    {{$trans('strings.Withdrawal')}}
                                </div>
                            </a>
                            <a href="#" class="action-button" data-bs-toggle="modal"
                               data-bs-target="#withdrawActionSheet2">
                                <div class="in">
                                    <div class="iconbox">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>
                                    </div>
                                    {{$trans('strings.Send')}}
                                </div>
                            </a>
                            <a href="history" class="action-button">
                                <div class="in">
                                    <div class="iconbox">
                                        <ion-icon name="card-outline"></ion-icon>
                                    </div>
                                    {{$trans('strings.My actions')}}
                                </div>
                            </a>
                        </div>
                        <!-- * action group -->
                        <!-- menu -->
                        <div class="listview-title mt-1">{{$trans('strings.Menu')}}</div>
                        <ul class="listview flush transparent no-line image-listview">
                            <li v-if="auth_user!==null">
                                <a href='user-profile' class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="person-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                       {{$trans('strings.User Profile')}}
                                    </div>
                                </a>
                            </li>
                            <li v-if="auth_user!==null">
                                <a href="history" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="receipt-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                       {{$trans('strings.History of actions')}}
                                    </div>
                                </a>
                            </li>
                            <li v-if="auth_user!==null">
                                <a href="achievements" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="medal-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                       {{$trans('strings.Achievements')}}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="products" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="cash-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Stocks')}}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="search-company" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="grid-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Companies')}}
                                    </div>
                                </a>
                            </li>
                            <li v-if="auth_user!==null">
                                <a href="friends" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="people-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Friends')}}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="news" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="newspaper-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.News')}}
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- * menu -->

                        <!-- others -->
                        <div class="listview-title mt-1">{{$trans('strings.Various')}}</div>
                        <ul class="listview flush transparent no-line image-listview">
                            <li v-if="auth_user!==null">
                                <a href="user-settings" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="settings-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Profile Settings')}}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="about-project" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="help-circle-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.About us')}}
                                    </div>
                                </a>
                            </li>
                            <li v-if="auth_user!==null">
                                <a href="#" @click.prevent="logout" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="log-out-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Log out')}}
                                    </div>
                                </a>
                            </li>
                            <li v-if="auth_user===null">
                                <a href="/login" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="log-in-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        {{$trans('strings.Log in to your account')}}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="item">
                                <LangSwitcher></LangSwitcher>
                                </div>
                            </li>
                        </ul>
                        <!-- * others -->
                    </div>
                </div>
            </div>
        </div>
        <TransactionsModal :title="$trans('strings.Cashback withdrawal')" modalID="withdrawActionSheet1"></TransactionsModal>
        <TransactionsModal :title="$trans('strings.Sending cashback')" modalID="withdrawActionSheet2"></TransactionsModal>
        <TransactionsModal :title="$trans('strings.Increase in total cashback')" modalID="depositActionSheet"
                           :recipient=false></TransactionsModal>
    </fragment>
</template>

<script>
import TransactionsModal from "../Modals/TransactionsModal";
import LangSwitcher from "./LangSwitcher";
export default {
    name: "SideMenu",
    components: {LangSwitcher, TransactionsModal},
    props: {
        auth_user: {
            default: null
        }
    },
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        currentTitle: '',
        profile: []
    }),
    mounted() {
        this.getProfileData()
    },
    methods: {
        logout: function () {
            axios.post('logout').then(response => {
                if (response.status === 302 || 401) {
                    window.location.href = '/';
                    console.log('logout')
                } else {
                    // throw error and go to catch block
                }
            }).catch(error => {

            });
        },
        getProfileData() {
            axios.get('api/profile/' + this.auth_user.id).then(response => {
                this.profile = response.data.profile
            })
        }

    },
}
</script>
