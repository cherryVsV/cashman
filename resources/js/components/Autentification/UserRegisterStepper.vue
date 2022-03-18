<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:right>
                <a href='login' class="headerButton">{{$trans('strings.Login')}}</a>
            </template>
        </Header>
        <div class="section mt-2 text-center">
            <form-wizard @onComplete="onComplete">
                <p>{{$trans('strings.Fill in your account information to complete registration')}}</p>
                <tab-content :title="$trans('strings.Email')" :selected="true">
                    <div class="form-group">
                        <label>{{$trans('strings.Email')}}</label>
                        <input
                            type="email"
                            class="form-control"
                            :class="hasError('email') ? 'is-invalid' : ''"
                            :placeholder="$trans('strings.Enter your email address')"
                            v-model="formData.email"
                            :disabled='isEmail'>
                        <div v-if="hasError('email')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.email.required">{{$trans('strings.Enter your email address')}}</div>
                            <div class="error" v-if="!$v.formData.email.email">{{$trans('strings.The entered email address has an incorrect format')}}
                            </div>
                        </div>
                    </div>

                </tab-content>
                <tab-content :title="$trans('strings.Password')">
                    <div class="form-group">
                        <label>{{$trans('strings.Password')}}</label>
                        <input
                            type="password"
                            class="form-control"
                            :class="hasError('password') ? 'is-invalid' : ''"
                            :placeholder="$trans('strings.Enter your password')"
                            v-model="formData.password">
                        <div v-if="hasError('password')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.password.required">{{$trans('strings.Enter your password')}}</div>
                            <div class="error" v-if="!$v.formData.password.minLength">{{$trans('strings.The password must be at least 8 characters long')}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{$trans('strings.Confirm Password')}}</label>
                        <input
                            type="password"
                            class="form-control"
                            :class="hasError('password_confirmation') ? 'is-invalid' : ''"
                            :placeholder="$trans('strings.Enter password confirmation')"
                            v-model="formData.password_confirmation">
                        <div v-if="hasError('password_confirmation')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.password_confirmation.required">{{$trans('strings.Enter password confirmation')}}
                            </div>
                            <div class="error" v-if="!$v.formData.password_confirmation.sameAs">{{$trans('strings.Passwords must match')}}
                            </div>
                        </div>
                    </div>
                </tab-content>
                <tab-content :title="$trans('strings.Terms of the agreement')">
                    <div class="form-group">
                        <label>{{$trans('strings.Read the terms of the agreement')}}</label>
                        <div class="form-group form-check">
                            <div class="custom-control custom-checkbox mt-2 mb-1">
                                <div class="form-check">
                                    <input v-model="formData.submitted" type="checkbox" class="form-check-input"
                                           :class="hasError('submitted') ? 'is-invalid' : ''"
                                           id="customCheckb1">
                                    <label class="form-check-label" for="customCheckb1">
                                        {{$trans('strings.I agree with')}}
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">
                                            {{$trans('strings.terms of the agreement')}}
                                        </a>
                                    </label>
                                    <div v-if="hasError('submitted')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.submitted.required">{{$trans('strings.Read the terms of the agreement')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tab-content>
            </form-wizard>
        </div>
        <BottomMenu></BottomMenu>
        <InformModal></InformModal>
    </fragment>
</template>

<script>
import {FormWizard, TabContent, ValidationHelper} from 'vue-step-wizard';
import {required, email, minLength, sameAs} from 'vuelidate/lib/validators';
import BottomMenu from "../LayoutComponents/BottomMenu";
import Header from "../LayoutComponents/Header";
import InformModal from "../Modals/InformModal";
import Form from "vform";

const checked = (value) => value === true;
export default {
    name: "UserRegisterStepper",
    components: {
        BottomMenu,
        FormWizard,
        TabContent,
        Header,
        InformModal
    },
    props: {
        email: {
            required: true
        }
    },
    mixins: [ValidationHelper],
    data() {
        return {
            formData: new Form({
                email: '',
                password: '',
                password_confirmation: '',
                submitted: ''
            }),
            validationRules: [
                {email: {required, email}},
                {password: {required, minLength: minLength(8)}, password_confirmation: {required}},
                {submitted: {checked}}
            ]
        }
    },
    mounted() {
        this.formData.email = this.email
    },
    computed: {
        isEmail() {
            return this.formData.email;
        }
    },
    methods: {
        onComplete() {
            this.formData.post('/register')
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire(
                'Поздравляем!',
                'Вы создали аккаунт в CashMan! Ваши данные сохранены',
                'success'
            ).then(() => {
                window.location.href = 'user-profile';
            })

        },
    }
}
</script>

<style scoped>

</style>
