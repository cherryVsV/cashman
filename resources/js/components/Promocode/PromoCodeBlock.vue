<template>
    <fragment>
        <Header class="no-border">
            <template v-slot:left>
                <a href="/user-profile" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:right>
                <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#DialogNotification">{{ $trans('strings.Help') }}</a>
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section">
                <div class="splash-page mt-5 mb-5">
                    <h2>{{ $trans('strings.Promo code activation') }}</h2>
                    <div class="mb-3">
                        <vue-qrcode :value=code :options="{ width: 200 }"></vue-qrcode>
                        <h3>{{ $trans('strings.User ID') }}</h3>
                        <h4>{{user}}</h4>
                    </div>
                    <h3 class="mb-2">{{ $trans('strings.Scan the QR Code') }}</h3>
                    <p>{{ description }}</p>
                </div>
            </div>
            <div class="fixed-bar">
                <div class="row">
                    <div class="col-12">
                        <a href="/user-profile" class="btn btn-lg btn-outline-secondary btn-block goBack">{{ $trans('strings.Go back') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <NotificationModal :title="$trans('strings.Promo code activation')"
                           :description="$trans('strings.Send a link to this page to a friend to invite him to the company and receive multi-level cashback!')">
        </NotificationModal>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import NotificationModal from "../Modals/NotificationModal";
import Footer from "../LayoutComponents/Footer";
import BottomMenu from "../LayoutComponents/BottomMenu";
import VueQrcode from '@chenfengyuan/vue-qrcode';

export default {
    name: "PromoCodeBlock",
    components: {BottomMenu, Footer, NotificationModal, Header, VueQrcode},
    props: {
        code: {
            required: true
        },
        user: {
            required: true
        },
        description: {
            type: String,
            default: "Отправьте ссылку на эту страницу другу, чтобы пригласить его в компанию и получать многоуровневый кэшбек!"
        }
    },
    mounted() {
        document.querySelector('body').classList.add('bg-white');
    }
}
</script>
