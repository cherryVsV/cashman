<template>
    <!-- App Capsule -->
    <div id="appCapsule" class="full-height">
        <Header class="border-0">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:right>
                <a href="login" class="headerButton">{{$trans('strings.Authorization')}}</a>
            </template>
        </Header>
        <div class="section mt-2 text-center">
            <h1>{{$trans('strings.Register')}}</h1>
            <h4>{{$trans('strings.Create an account in Cashman!')}}</h4>
        </div>
        <div class="section mb-5 p-2">
            <AlertErrors :form="form" class="mb-2"></AlertErrors>
            <form @submit.prevent="registerUser"
                  @keydown="form.onKeydown($event)">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email">{{$trans('strings.Email')}}</label>
                                <input type="email" class="form-control" id="email"
                                       :placeholder="$trans('strings.Enter your email address')"
                                       v-model="form.email" name="email">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="email"/>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password">{{$trans('strings.Password')}}</label>
                                <input type="password" class="form-control" id="password" autocomplete="new-password"
                                       :placeholder="$trans('strings.Enter your password')" name="password"
                                       v-model="form.password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="password"/>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password-confirmation">{{$trans('strings.Repeat the password')}}</label>
                                <input type="password" class="form-control" id="password-confirmation"
                                       autocomplete="new-password"
                                       :placeholder="$trans('strings.Repeat the password')"
                                       name="password_confirmation"
                                       v-model="form.password_confirmation">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="password_confirmation"/>
                        </div>
                        <div class="custom-control custom-checkbox mt-2 mb-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="customCheckb1"
                                       v-model="form.submitted">
                                <label class="form-check-label" for="customCheckb1">
                                    <a>{{$trans('strings.I agree with')}}</a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">
                                        {{$trans('strings.terms of the agreement')}}
                                    </a>
                                </label>
                                <HasError :form="form" field="submitted"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="social_icon">
                    <div class="section mt-2 text-center border-bottom">
                    </div>
                    <div class="section py-2 px-1 text-center">
                        <a class="btn btn-icon btn-facebook  me-05" href="auth/facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="btn btn-icon btn-google me-05" href="auth/google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a class="btn btn-icon btn-vk me-05" href="auth/vkontakte">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a class="btn btn-icon btn-telegram me-05" href="auth/telegram">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a class="btn btn-icon btn-yandex me-05" href="auth/yandex">
                            <i class="fab fa-yandex"></i>
                        </a>
                    </div>
                </div>
                <div class="form-button-group">
                    <button type="submit" :disabled='form.errors.any() || !isComplete'
                            class="btn btn-primary btn-block btn-lg">{{$trans('strings.Register')}}
                    </button>
                </div>
            </form>
        </div>
        <InformModal></InformModal>
    </div>
</template>

<script>
import Form from "vform"
import {AlertErrors, HasError} from "vform/src/components/bootstrap5"
import InformModal from "../Modals/InformModal";
import Header from "../LayoutComponents/Header";

export default {
    components: {InformModal, Header, AlertErrors, HasError},
    name: "UserRegisterSection",
    data: function () {
        return {
            form: new Form({
                email: '',
                password: '',
                password_confirmation: '',
                submitted: '',
                lang: null
            })
        }
    },
    methods: {
        async registerUser() {
            this.form.lang = localStorage.getItem('locale')
            await this.form.post('/register')
            window.location.href = 'user-profile';
        }
    },
    computed: {
        isComplete() {
            return this.form.email && this.form.password && this.form.password_confirmation && this.form.submitted;
        }
    }
}
</script>
