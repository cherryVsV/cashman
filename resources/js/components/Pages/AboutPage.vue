<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.About us')}}
            </template>
            <template v-slot:right>
                <a href="history" class="headerButton">
                    <ion-icon class="icon" name="notifications-outline"></ion-icon>
                    <span class="badge badge-danger">4</span>
                </a>
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section full">
                <img src="assets/sample/photo/wide3.jpg" alt="image" class="imaged w-100 square">
            </div>
            <div class="section mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{$trans('strings.About us')}}</h2>
                        Finapp is Bootstrap 5 based template for your wallet, banking, financial mobile projects.
                    </div>
                </div>
            </div>
            <div class="section mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{$tans('Learn More')}}</h2>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce mollis iaculis aliquet. Duis
                        euismod
                        nibh at neque gravida tincidunt. Nunc vitae fringilla augue. Nunc blandit tempor enim porttitor
                        bibendum. In ac blandit quam. Quisque laoreet ligula eu commodo cursus. In efficitur convallis
                        felis.
                    </div>
                </div>
            </div>
            <div class="section full mt-3">
                <!-- carousel single -->
                <div class="carousel-single splide">
                    <div class="splide__track">
                        <ul class="splide__list">

                            <li class="splide__slide">
                                <img src="assets/sample/photo/wide1.jpg" alt="alt" class="imaged w-100">
                            </li>

                            <li class="splide__slide">
                                <img src="assets/sample/photo/wide2.jpg" alt="alt" class="imaged w-100">
                            </li>

                            <li class="splide__slide">
                                <img src="assets/sample/photo/wide3.jpg" alt="alt" class="imaged w-100">
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- * carousel single -->
            </div>
            <CallbackForm></CallbackForm>
            <div class="section mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="p-1">
                            <div class="text-center">
                                <h2 class="text-primary">{{$trans('strings.Our Address')}}</h2>
                                <p class="card-text">
                                    PO Box 16122 Collins Street West<br>
                                    Victoria 8007 Australia
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="p-1">
                            <div class="text-center">
                                <h2 class="text-primary mb-2">{{$trans('strings.Social Network')}}</h2>
                                <a class="btn btn-icon btn-facebook  me-05" href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn btn-icon btn-twitter me-05" href="#">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="btn btn-icon btn-google me-05" href="#">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a class="btn btn-icon btn-vk me-05" href="#">
                                    <i class="fab fa-vk"></i>
                                </a>
                                <a class="btn btn-icon btn-telegram me-05" href="#">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a class="btn btn-icon btn-yandex me-05" href="#">
                                    <i class="fab fa-yandex"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import CallbackForm from "../Callback/CallbackForm";
import Footer from "../LayoutComponents/Footer";
import BottomMenu from "../LayoutComponents/BottomMenu";

export default {
    name: "AboutPage",
    components: {BottomMenu, Footer, CallbackForm, Header}
}
</script>
