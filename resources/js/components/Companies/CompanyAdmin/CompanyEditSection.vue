<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Changing company data')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2 text-center">
                <div class="avatar-section">
                    <a href="#">
                        <img :src="'assets/sample/'+company.image" alt="avatar" class="imaged w100 rounded">
                    </a>
                </div>
                <h1>{{$trans('strings.Company information')}}</h1>
                <h4>{{$trans('strings.Fill in your company details')}}</h4>
            </div>
            <div class="section mb-5 p-2">
                <form @submit.prevent="updateSettings" @keydown="company.onKeydown($event)">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="title">{{$trans('strings.Title')}}</label>
                                    <input type="text" class="form-control" :placeholder="$trans('strings.Company name')"
                                           v-model="company.title" name="title" id="title">
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
                                        <h3 class="dropzone-custom-title">{{$trans('strings.Drag and drop to upload content!')}}</h3>
                                        <div class="subtitle">{{$trans('strings.or click to select a file from your computer')}}</div>
                                    </div>
                                </vue-dropzone>
                            </div>


                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="percent">{{$trans('strings.Cashback percentage')}}</label>
                                    <input type="text" class="form-control" id="percent"
                                           :placeholder="$trans('strings.Cashback percentage')" v-model="company.cashback_percent"
                                           name="cashback_percent">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="percent1">{{$trans('strings.Level 1 Cashback percentage')}}</label>
                                    <input type="text" class="form-control" id="percent1"
                                           :placeholder="$trans('strings.Level 1 Cashback percentage')"
                                           v-model="company.cashback_percent_level_1" name="cashback_percent_level_1">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="percent2">{{$trans('strings.Level 2 Cashback percentage')}}</label>
                                    <input type="text" class="form-control" id="percent2"
                                           :placeholder="$trans('strings.Level 2 Cashback percentage')"
                                           v-model="company.cashback_percent_level_2" name="cashback_percent_level_2">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="description">{{$trans('strings.Company Description')}}</label>
                                    <textarea type="text" class="form-control" id="description"
                                              :placeholder="$trans('strings.Company Description')" v-model="company.description"
                                              name="description" @onKeyUp="SetNewSize(this)" cols="5"
                                              rows="6"></textarea>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="callback">{{$trans('strings.Link for feedback')}}</label>
                                    <input type="text" class="form-control" id="callback"
                                           :placeholder="$trans('strings.Link for feedback')" v-model="company.callback_url"
                                           name="callback_url">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="vk-url">{{$trans('strings.Link to download products from VK')}}</label>
                                    <input type="text" class="form-control" id="vk-url"
                                           :placeholder="$trans('strings.Link to download products from VK')"
                                           v-model="company.upload_vk_url" name="upload_vk_url">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <label class="label">{{$trans('strings.Additional information')}}
                                    <button @click="addProperty" type="button" class="btn btn-icon btn-info me-1">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </button>
                                </label>
                                <ul class="listview image-listview no-line no-space flush">
                                    <li v-for="(property, key) in company.properties">
                                        <div class="item flex-wrap flex-column d-flex">
                                            <p class="mb-0 w-100">{{ key }} : </p>
                                            <div class="in mb-1 w-100">
                                                <div class="input-wrapper w-100">
                                                    <input type="text" class="form-control"
                                                           :placeholder="key"
                                                           v-model="company.properties[key]">
                                                    <i class="clear-input">
                                                        <ion-icon name="close-circle"></ion-icon>
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li v-for="input in inputs">
                                        <div class="input-wrapper w-100"
                                             style="display: flex!important; margin: 10px 0!important;">
                                            <input type="text" class="form-control"
                                                   placeholder="Вид информации"
                                                   v-model="type">
                                            <i class="clear-input">
                                                <ion-icon name="close-circle"></ion-icon>
                                            </i>
                                            <input type="text" class="form-control"
                                                   :placeholder="input.placeholder"
                                                   :disabled="!newKey"
                                                   v-model="company.properties[type]">
                                            <i class="clear-input">
                                                <ion-icon name="close-circle"></ion-icon>
                                            </i>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <div class="form-group basic">
                                <label class="label">{{$trans('strings.Social network')}}</label>
                                <ul class="listview image-listview no-line no-space flush">
                                    <li v-for="(social, key) in company.socials">
                                        <div class="item">
                                            <div class="icon-box bg-primary">
                                                <i :class="'fab fa-'+key"></i>
                                            </div>
                                            <div class="in">
                                                <div class="input-wrapper w-100">
                                                    <input type="text" class="form-control" id="socials1"
                                                           :placeholder="$trans('strings.Link to the profile in')+key"
                                                           v-model="company.socials[key]">
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
import Header from "../../LayoutComponents/Header";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    name: "CompanyEditSection",
    components: {Header, vueDropzone: vue2Dropzone},
    props: {
        company: {
            required: true
        }
    },
    data() {
        return {
            inputs: [],
            type: '',
            dropzoneOptions: {
                url: "api/files",
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            }
        }
    },
    computed: {
        newKey() {
            return this.type
        }
    },
    methods: {
        updateSettings() {
            axios.post('api/company/settings', this.company).then(function (response) {
                if (response.data.href !== undefined) {
                    location.href = response.data.href
                } else {
                    //location.reload(true);
                }

            })
                .catch(function (error) {
                    console.log(error);
                });

        },
        addProperty() {
            if (this.inputs.length > 0) {
                this.inputs.splice(this.inputs.length - 1)
                this.type = ''
            }
            this.inputs.push({
                placeholder: 'Дополнительная информация '
            })

        },
        SetNewSize(textarea) {
            if (textarea.value.length > 5) {
                textarea.cols = 50;
                textarea.rows = 50;
            } else {
                textarea.cols = 10;
                textarea.rows = 15;
            }
        },
        uploadSuccess(file, response) {
            this.company.image = response.file;
        },

        fileRemoved() {
        }
    }
}
</script>

<style scoped>

</style>
