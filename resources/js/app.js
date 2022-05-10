/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import {localeChanged, localize} from "vee-validate";

require('./bootstrap');
window.Vue = require('vue').default;

export const eventBus = new Vue()
import LoadScript from 'vue-plugin-load-script';
Vue.use(LoadScript);
import 'dtoaster/dist/dtoaster.css'
import DToaster from 'dtoaster'
import ToasterPresets from './json/toast_presets.json' //Your predefined toasts presets (optionally)
Vue.use(DToaster, {
    presets: ToasterPresets,
    position: 'top-right',
    containerOffset: '45px',
})
import Fragment from 'vue-fragment'
Vue.use(Fragment.Plugin)

import VueLazyload from 'vue-lazyload'
Vue.use(VueLazyload, {
    preLoad: 1,
    error: 'assets/logo-icon.png',
    loading: 'assets/loading.gif',
    attempt: 1
})

import store from './store/index'

import moment from 'moment';
Vue.filter('myDate', function(date){
    moment.locale(localStorage.getItem('locale'));
    return moment(date).format("LL");
});

Vue.config.ignoredElements = [/^ion-/]

import Swal from 'sweetalert2'
window.Swal = Swal;

var VueScrollTo = require('vue-scrollto');
Vue.use(VueScrollTo)


require('lang.js');
import VueLang from '@eli5/vue-lang-js'
import translations from './vue-translations.json';

Vue.use(VueLang, {
    messages: translations, // Provide locale file
    locale: 'en', // Set locale
    fallback: 'ru' // Set fallback locale
});
import YmapPlugin from 'vue-yandex-maps'
const settings = {
    apiKey: '865b6aaf-1477-4185-ac17-c503079aa759',
    lang: localStorage.getItem('faker_locale'),
    coordorder: 'latlong',
    version: '2.1'
}
Vue.use(YmapPlugin, settings)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//User Authentication
Vue.component('user-login-component', require('./components/Autentification/UserLoginSection').default);
Vue.component('user-register-component', require('./components/Autentification/UserRegisterSection').default);
Vue.component('user-register-stepper', require('./components/Autentification/UserRegisterStepper').default);

//Pages
Vue.component('main-page', require('./components/Pages/MainPage').default);
Vue.component('user-page', require('./components/Pages/UserProfilePage').default);
Vue.component('user-settings', require('./components/Pages/UserSettingsPage').default);
Vue.component('achievement', require('./components/Pages/AchievemеntPage').default);
Vue.component('achievement-detail', require('./components/Achievements/AchievementDetail').default);
Vue.component('history', require('./components/Pages/HistoryPage').default);
Vue.component('history-action-detail', require('./components/HistoryAction/HistoryActionDetail').default);
Vue.component('user-friends', require('./components/Users/UserFriendsList').default);
Vue.component('users-friends-tree', require('./components/Users/UsersFriendsTree').default);
Vue.component('news', require('./components/Pages/NewsPage').default);
Vue.component('news-detail', require('./components/News/NewsDetail').default);
Vue.component('page-not-found', require('./components/Pages/NotFoundPage').default);
Vue.component('promo-code', require('./components/Promocode/PromoCodeBlock').default);
Vue.component('about-page', require('./components/Pages/AboutPage').default);
Vue.component('landing-page', require('./components/Pages/LandingPage').default);
Vue.component('company-profile', require('./components/Companies/CompanyProfile').default);
Vue.component('ad-list', require('./components/Companies/ADComponents/Stepper').default);
Vue.component('search-company', require('./components/Companies/SearchCompanySection').default);
Vue.component('edit-company', require('./components/Companies/CompanyAdmin/CompanyEditSection').default);
Vue.component('edit-profile', require('./components/Pages/UserProfileEditSection').default);
Vue.component('region-map-block', require('./components/Companies/RegionMapBlock').default);
Vue.component('activity-history-page', require('./components/ActivityHistory/ActivityHistoryPage').default);
//Company Admin
Vue.component('company-admin-menu', require('./components/Companies/CompanyAdmin/CRUD/CompanyAdminMenu').default);
Vue.component('company-admin-products', require('./components/Companies/CompanyAdmin/CRUD/ProductsTable').default);
Vue.component('company-admin-advertisement', require('./components/Companies/CompanyAdmin/CRUD/AdvertisementTable').default);
Vue.component('company-admin-achievements', require('./components/Companies/CompanyAdmin/CRUD/AchievementsTable').default);
Vue.component('company-admin-users', require('./components/Companies/CompanyAdmin/CRUD/UsersTable').default);
Vue.component('story-admin-menu', require('./components/Companies/CompanyAdmin/StoryAdminMenu').default);
Vue.component('company-action-menu', require('./components/Companies/CompanyAdmin/CompanyActionMenu').default);
Vue.component('company-group-admin', require('./components/Companies/CompanyAdmin/CompanyGroupAdmin').default);
Vue.component('add-promocode', require('./components/Companies/CompanyAdmin/CRUD/AddPromocodeBlock').default);
Vue.component('company-tariffs', require('./components/Companies/CompanyAdmin/CompanyTariffs').default);
//Company Authentication
Vue.component('company-register-component', require('./components/Companies/CompanyAuth/CompanyRegisterSection').default);
Vue.component('company-login-component', require('./components/Companies/CompanyAuth/CompanyLoginSection').default);
Vue.component('company-complete-registration', require('./components/Companies/CompanyAuth/CompanyRegisterStepper').default);
//Products
Vue.component('products', require('./components/Products/ProductList').default);
Vue.component('product-detail', require('./components/Products/ProductDetail').default);

Vue.component('side-menu', require('./components/LayoutComponents/SideMenu').default);
Vue.component('comment', require('./components/Products/Comment'));
Vue.component('comments', require('./components/Products/Comments'))
Vue.component('new-comment', require('./components/Products/NewComment'))

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;
window.Fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
axios.get('/locale').then((response)=>{
    localStorage.setItem('locale', response.data.locale);
    if(response.data.locale === 'ru'){
        localStorage.setItem('faker_locale', 'ru_RU');
    }else{
        localStorage.setItem('faker_locale', 'en_US');
    }
});
if (localStorage.getItem('locale')) {
    app.$lang.setLocale(localStorage.getItem('locale'));
    localize(localStorage.getItem('locale'));
    localeChanged();
} else {
    localStorage.setItem('locale', 'en');
    app.$lang.setLocale('en');
    localize('en');
    localeChanged();
}



