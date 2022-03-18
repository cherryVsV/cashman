<template>
    <div id="appCapsule" class="full-height">
        <Header class="border-0">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
        </Header>
        <div class="section mt-2 text-center">
            <h1>{{$trans('strings.Authorization')}}</h1>
            <h4>{{$trans('strings.Fill out the authorization form')}}</h4>
        </div>
        <div class="section mb-5 p-2">
            <AlertErrors :form="form" class="mb-2"></AlertErrors>
            <form @submit.prevent="loginUser"
                  @keydown="form.onKeydown($event)">
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email">{{$trans('strings.Email')}}</label>
                                <input v-model="form.email" type="email" name="email" id="email"
                                       :placeholder="$trans('strings.Enter your email address')"
                                       class="form-control">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="email"/>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password">{{$trans('strings.Password')}}</label>
                                <input v-model="form.password" type="password" id="password" name="password"
                                       autocomplete="off"
                                       :placeholder="$trans('strings.Enter your email address')"
                                       class="form-control">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="password"/>
                        </div>
                    </div>
                </div>
                <div class="form-links mt-2">
                    <div>
                        <a href="register">{{ $trans('strings.Register') }}</a>
                    </div>
                    <div>
                        <a href="password/reset" class="text-muted">{{$trans('strings.Forgot Your Password?')}}</a>
                    </div>
                </div>
                <div class="form-button-group">
                    <button type="submit" :disabled='form.errors.any() || !isComplete'
                            class="btn btn-primary btn-block btn-lg">{{$trans('strings.Login')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Header from "../LayoutComponents/Header";
import Form from "vform"
import {AlertErrors, HasError} from "vform/src/components/bootstrap5"
export default {
    name: "UserLoginSection",
    components: {Header, HasError, AlertErrors},
    data: function () {
        return {
            form: new Form({
                email: '',
                password: ''
            })
        }
    },
    methods: {
        async loginUser() {
            await this.form.post('login')
            window.location.href = 'user-profile';
        },
    },
    computed: {
        isComplete() {
            return this.form.email && this.form.password;
        }
    }
}
</script>
