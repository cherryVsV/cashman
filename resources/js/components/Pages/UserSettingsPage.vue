<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
               {{$trans('strings.Settings')}}
            </template>
            <template v-slot:right>
                <a href="#" class="headerButton">
                    <ion-icon class="icon" name="notifications-outline"></ion-icon>
                    <span class="badge badge-danger">1</span>
                </a>
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-3 text-center">
                <div class="avatar-section">
                    <a href="#">
                        <img :src="'assets/sample/'+profile.avatar" alt="avatar" class="imaged w100 rounded">
                        <span class="button" @click="changeAvatar">
                        <ion-icon name="camera-outline"></ion-icon>
                    </span>
                    </a>
                </div>
            </div>
            <div class="listview-title mt-1">{{$trans('strings.Theme')}}</div>
            <ul class="listview image-listview text inset">
                <li>
                    <div class="item">
                        <div class="in">
                            <div>{{$trans('strings.Dark theme')}}</div>
                            <div class="form-check form-switch  ms-2">
                                <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch">
                                <label class="form-check-label" for="darkmodeSwitch"></label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="listview-title mt-1">{{$trans('strings.Companies')}}</div>
            <ul class="listview image-listview text inset">
                <li>
                    <a href="register-company" class="item">
                        <div class="in">
                            <div>
                                {{$trans('strings.Company registration')}}
                                <div class="text-muted">
                                    {{$trans('strings.Here you can add your new company')}}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="login-company" class="item">
                        <div class="in">
                            <div>
                                {{$trans('strings.Company authorization')}}
                                <div class="text-muted">
                                   {{$trans('strings.Here you can log in to your company')}}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="listview-title mt-1">{{$trans('strings.Profile Settings')}}</div>
            <ul class="listview image-listview text inset">
                <li>
                    <a href="/user-edit" class="item">
                        <div class="in">
                            <div>{{$trans('strings.Change Profile Settings')}}</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" @click="changeEmail" class="item">
                        <div class="in">
                            <div>{{ $trans('strings.Update Email Address') }}</div>
                        </div>
                    </a>
                </li>

            </ul>
            <div class="listview-title mt-1">{{$trans('strings.Security')}}</div>
            <ul class="listview image-listview text mb-2 inset">
                <li>
                    <a href="#" @click="changePassword" class="item">
                        <div class="in">
                            <div>{{ $trans('strings.Update Password') }}</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" @click.prevent="logout" class="item">
                        <div class="in">
                            <div>{{ $trans('strings.Log out from all devices') }}</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
        <ChangeEmailModal :id="this.user.id"></ChangeEmailModal>
        <ChangeAvatarModal :id="this.user.id" @updateParent="getProfileData"></ChangeAvatarModal>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import Footer from "../LayoutComponents/Footer";
import BottomMenu from "../LayoutComponents/BottomMenu";
import ChangeEmailModal from "../Modals/ChangeEmailModal";
import ChangeAvatarModal from "../Modals/ChangeAvatarModal";

export default {
    name: "UserSettingsPage",
    components: {ChangeAvatarModal, ChangeEmailModal, Header, Footer, BottomMenu},
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        profile: []
    }),
    methods: {
        logout: function () {
            axios.post('logout').then(response => {
                if (response.status === 302 || 401) {
                    window.location.href = '/';
                } else {
                    // throw error and go to catch block
                }
            }).catch(error => {

            });
        },
        getProfileData() {
            axios.get('api/profile/' + this.user.id).then(response => {
                this.profile = response.data.profile
            })
        },
        changePassword() {
            let email = {email: this.profile.email}
            axios.post('password/email', email).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Проверьте почту!',
                    text: 'Письмо для подтверждения смены пароля отправлено на вашу почту - ' + this.profile.email,
                })
            })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Что-то пошло не так...',
                        text: 'Повторите действие позднее',
                    })
                })
        },
        changeEmail() {
            $('#ChangeEmailModal').modal('show');
        },
        changeAvatar() {
            $('#ChangeAvatarModal').modal('show');
        }
    },
    props: {
        user: {
            required: true
        }
    },
    mounted() {
        this.getProfileData()
    }
}
</script>
