<template>
    <div id="appCapsule" class="full-height">
        <Header class="bg-transparent border-0">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
        </Header>
        <div class="section mt-2 text-center">
            <h1>{{$trans('strings.Log in to your company account')}}</h1>
            <h4>{{$trans('strings.Fill out the form to enter the company')}}</h4>
        </div>
        <div class="section mb-5 p-2">
            <AlertErrors :form="form" class="mb-2"></AlertErrors>
            <form @submit.prevent="loginCompany" @keydown="form.onKeydown($event)">
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="domain">{{$trans('strings.Domain')}}</label>
                                <input v-model="form.domain" type="text" class="form-control"
                                       id="domain"
                                       :placeholder="$trans('strings.Enter your company domain')"
                                name="domain">
                                <i class="clear-input">
                                    <ion-icon name="close-circle-outline"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="domain"/>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password">{{$trans('strings.Password')}}</label>
                                <input v-model="form.password" type="password" class="form-control"
                                       id="password"
                                       autocomplete="off"
                                       :placeholder="trans('Enter your company\'s password')" name="password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle-outline"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="password"/>
                        </div>
                    </div>
                </div>
                <div class="form-links mt-2">
                    <div>
                        <a href="register-company">{{$trans('strings.Register company')}}</a>
                    </div>
                </div>
                <div class="form-button-group  transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">{{$trans('strings.Login')}}</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Header from "../../LayoutComponents/Header";
import Form from "vform"
import {AlertErrors, HasError} from "vform/src/components/bootstrap5"

const swal = Swal.mixin()
export default {
    name: "CompanyLoginSection",
    components: {Header, HasError, AlertErrors},
    data: function () {
        return {
            form: new Form({
                domain: '',
                password: ''
            }),
        }
    },
    methods: {
        loginCompany() {

            this.form.post('/login-company').then(function (response) {
                if (response.data.href !== undefined) {
                    location.href = response.data.href
                } else if (response.data.error !== undefined) {
                    swal.fire({
                        title: 'Вам отказано в доступе к данной компании!',
                        text: "Неправильно введенный домен ли пароль компании",
                        icon: 'warning'
                    })
                }

            })

        }
    }
}
</script>
