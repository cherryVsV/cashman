<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Add a promo code')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2 text-center">
                <h1>{{$trans('strings.Enter the characters for the promo code')}}</h1>
                <h4>{{$trans('strings.The number of characters must not exceed 12')}}</h4>
            </div>
            <div class="section mb-5 p-2">
                <form action="/company-admin-menu">
                    <div class="form-group basic">
                        <input type="text" class="form-control verification-input w-100" id="smscode"
                               placeholder="••••••••••••"
                               maxlength="12">
                    </div>

                    <div class="form-button-group transparent">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">{{$trans('strings.Create a promo code')}}</button>
                    </div>

                </form>
            </div>

        </div>
    </fragment>
</template>

<script>
import Header from "../../../LayoutComponents/Header";

export default {
    name: "AddPromocodeBlock",
    components: {Header}
}
</script>

<style scoped>
@media screen and (min-width: 768px) and (max-width: 992px) {
    .verification-input {
        width: 65% !important;
    }
}

@media screen and (min-width: 576px) and (max-width: 768px) {
    .verification-input {
        width: 80% !important;
    }
}

@media screen and (max-width: 576px) {
    .verification-input {
        width: 95% !important;
    }
}

@media screen and (max-width: 440px) {
    .verification-input {
        width: 95% !important;
        font-size: 16px !important;
    }
}
</style>
