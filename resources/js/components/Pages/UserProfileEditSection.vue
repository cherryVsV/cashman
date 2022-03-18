<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Changing Profile data')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2 text-center">
                <div class="avatar-section">
                    <a href="#">
                        <img :src="'assets/sample/'+profile.avatar" alt="avatar" class="imaged w100 rounded">
                    </a>
                </div>
                <h1>{{$trans('strings.Profile Data')}}</h1>
                <h4>{{$trans('strings.Fill in your profile details')}}</h4>
            </div>
            <div class="section mb-5 p-2">
                <form @submit.prevent="updateSettings">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="name">{{$trans('strings.Action Name')}}</label>
                                    <input type="text" class="form-control" :placeholder="$trans('strings.Enter your name')"
                                           v-model="profile.name" name="name" id="name">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <vue-dropzone
                                    ref="myVueDropzone"
                                    id="dropzone"
                                    :options="dropzoneOptions"
                                    :useCustomSlot="true"
                                    v-on:vdropzone-success="uploadSuccess"
                                    v-on:vdropzone-removed-file="fileRemoved"
                                >
                                    <div class="dropzone-custom-content">
                                        <div class="dropzone-custom-content">
                                            <h3 class="dropzone-custom-title">{{$trans('strings.Drag and drop to upload content!')}}</h3>
                                            <div class="subtitle">{{$trans('strings.or click to select a file from your computer')}}</div>
                                        </div>
                                    </div>
                                </vue-dropzone>

                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="password1">{{$trans('strings.Phone Number')}}</label>
                                    <input type="text" class="form-control" id="password1" autocomplete="off"
                                           :placeholder="$trans('strings.Enter your phone number')" v-model="profile.phone"
                                           name="phone">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="country">{{$trans('strings.Country')}}</label>
                                    <input type="text" class="form-control" id="country"
                                           :placeholder="$trans('strings.Country')" v-model="profile.country"
                                           name="country">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="region">{{$trans('strings.Region')}}</label>
                                    <input type="text" class="form-control" id="region"
                                           :placeholder="$trans('strings.Region')"
                                           v-model="profile.region" name="region">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="address">{{$trans('strings.Address')}}</label>
                                    <input type="text" class="form-control" id="address"
                                           :placeholder="$trans('strings.Address')"
                                           v-model="profile.address" name="address">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <label class="label">{{$trans('strings.Social Network')}}</label>
                                <ul class="listview image-listview no-line no-space flush">
                                    <li v-for="(messenger, key) in profile.messengers">
                                        <div class="item">
                                            <div class="icon-box bg-primary">
                                                <i :class="'fab fa-'+key"></i>
                                            </div>
                                            <div class="in">
                                                <div class="input-wrapper w-100">
                                                    <input type="text" class="form-control" id="socials1"
                                                           :placeholder="$trans('strings.Link to the profile in')+key"
                                                           v-model="profile.messengers[key]">
                                                    <i class="clear-input">
                                                        <ion-icon name="close-circle"></ion-icon>
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-button-group transparent">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            {{$trans('strings.Update')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    name: "UserProfileEditSection",
    components: {Header, vueDropzone: vue2Dropzone},
    props: {
        profile: {
            required: true
        }
    },
    data() {
        return {
            dropzoneOptions: {
                url: "api/avatars",
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            }
        }
    },
    methods: {
        updateSettings() {
            axios.post('api/user/settings', this.profile)
                .then(function (response) {
                    // if(response.status === 200 || 302 || 401) {
                    window.location.href = 'user-profile';
                    //}
                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        uploadSuccess(file, response) {
            this.profile.avatar = response.file;
        },

        fileRemoved() {
        }
    }
}
</script>

<style scoped>

</style>
