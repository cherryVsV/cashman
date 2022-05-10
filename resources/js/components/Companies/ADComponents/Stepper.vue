<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Add Ads')}}
            </template>
        </Header>
        <br/>
        <form-wizard @onComplete="onComplete" enctype="multipart/form-data">
            <tab-content :title="$trans('strings.Title and description of the ad')" :selected="true">
                <div class="form-group">
                    <label>{{$trans('strings.Title')}}</label>
                    <input
                        type="text"
                        class="form-control"
                        :class="hasError('title') ? 'is-invalid' : ''"
                        :placeholder="$trans('strings.Enter the title of the ad')"
                        v-model="formData.title">
                    <div v-if="hasError('title')" class="invalid-feedback">
                        <div class="error" v-if="!$v.formData.title.required">{{$trans('strings.Enter the title of the ad')}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{$trans('strings.Description')}}</label>
                    <input
                        type="text"
                        class="form-control"
                        :class="hasError('description') ? 'is-invalid' : ''"
                        :placeholder="$trans('strings.Enter a description of the ad')"
                        v-model="formData.description">
                    <div v-if="hasError('description')" class="invalid-feedback">
                        <div class="error" v-if="!$v.formData.description.required">{{$trans('strings.Enter a description of the ad')}}</div>
                    </div>
                </div>
            </tab-content>
            <tab-content :title="$trans('strings.Image and type of advertisement')">
                <div class="form-group">
                    <label class="control-label col-lg-1 text-semibold">{{$trans('strings.Image')}}</label>
                    <vue-dropzone
                        ref="myVueDropzone"
                        id="dropzone"
                        :class="hasError('image') ? 'is-invalid' : ''"
                        :options="dropzoneOptions"
                        :useCustomSlot="true"
                        v-on:vdropzone-success="uploadSuccess"
                        v-on:vdropzone-removed-file="fileRemoved"
                    >
                        <div class="dropzone-custom-content">
                            <h3 class="dropzone-custom-title">{{$trans('strings.Drag and drop to upload content!')}}</h3>
                            <div class="subtitle">{{$trans('strings....or click to select a file from your computer')}}</div>
                        </div>
                    </vue-dropzone>
                    <div v-if="hasError('image')" class="invalid-feedback">
                        <div class="error" v-if="!$v.formData.image.required">{{$trans('strings.Add an ad image')}}
                        </div>
                    </div>
                </div>
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="select4">{{$trans('strings.Select the type of ad')}}</label>
                        <select class="form-control custom-select" id="select4" v-model="formData.type">
                            <option value="Сторис">{{$trans('strings.History')}}</option>
                            <option value="Баннер">{{$trans('strings.News')}}</option>
                        </select>
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
                                    <a>{{$trans('strings.I agree with')}}</a>
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
        <BottomMenu></BottomMenu>
        <InformModal></InformModal>
    </fragment>
</template>

<script>
import {FormWizard, TabContent, ValidationHelper} from 'vue-step-wizard'
import {required} from 'vuelidate/lib/validators';
import InformModal from "../../Modals/InformModal";
import BottomMenu from "../../LayoutComponents/BottomMenu";
import Header from "../../LayoutComponents/Header";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

const checked = (value) => value === true;
export default {
    name: "StepFormValidation",
    components: {
        BottomMenu,
        InformModal,
        FormWizard,
        TabContent,
        Header,
        vueDropzone: vue2Dropzone
    },
    mixins: [ValidationHelper],
    data() {
        return {
            formData: {
                title: '',
                description: '',
                images: '',
                type: 'Сторис',
                terms: false
            },
            validationRules: [
                {title: {required}, description: {required}},
                {images: {required}},
                {terms: {checked}}
            ],
            dropzoneOptions: {
                url: 'api/add-story',
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            }
        }
    },
    props: {
        id: {
            required: true
        }
    },

    methods: {
        onComplete() {
            axios.post('api/admin/add-advertisement-' + this.id, this.formData)
                .then(() => {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire(
                        'Поздравляем!',
                        'Вы добавили новую рекламу своей компании',
                        'success',
                    )
                    window.location.href = 'company-admin-menu-' + this.id
                })
        },
        uploadSuccess(file, response) {
            this.formData.images = response.file;
        },
        fileRemoved() {
        }
    },

}
</script>
