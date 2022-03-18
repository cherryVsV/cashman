<template>
    <div class="modal fade" id="AddNew" tabindex="-1" aria-labelledby="AddNewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateLabel">{{ $trans('strings.Edit advertisement') }}</h5>
                </div>
                <form @submit.prevent="updateAdvertisement()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ $trans('strings.Advertisement title') }}</label>
                            <input v-model="form.title" type="text" name="title"
                                   :placeholder="$trans('strings.Advertisement title')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <HasError :form="form" field="title"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Advertisement description') }}</label>
                            <input v-model="form.description" type="text" name="description"
                                   :placeholder="$trans('strings.Advertisement description')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <HasError :form="form" field="description"></HasError>
                        </div>

                        <div class="form-group">
                            <label>{{$trans('strings.Add an ad image')}}</label>
                            <img :src="'./../assets/sample/'+form.images.main" alt="image"
                                 class="imaged w100">
                            <vue-dropzone
                                ref="myVueDropzone"
                                id="dropzone"
                                :options="dropzoneOptions"
                                :useCustomSlot="true"
                                v-on:vdropzone-success="uploadSuccess"
                                v-on:vdropzone-removed-file="fileRemoved"
                            >
                                <div class="dropzone-custom-content">
                                    <h3 class="dropzone-custom-title">
                                        {{ $trans('strings.Drag and drop to upload content!') }}</h3>
                                    <div class="subtitle">
                                        {{ $trans('strings.or click to select a file from your computer') }}
                                    </div>
                                </div>
                            </vue-dropzone>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="filesRemove">
                            {{$trans('strings.Close')}}
                        </button>
                        <button type="submit" class="btn btn-success">{{$trans('strings.Update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {HasError} from "vform/src/components/bootstrap5"
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: "AdvertisementModal",
    components: {HasError, vueDropzone: vue2Dropzone},
    props: {
        form: {
            required: true
        }
    },
    data() {
        return {
            dropzoneOptions: {
                url: 'api/add-story',
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            },
            newImage: ''
        }
    },
    methods: {

        uploadSuccess(file, response) {
            this.newImage = 'news/' + response.file;
        },
        fileRemoved() {
            this.newImage = ''
        },
        filesRemove() {
            this.$refs.myVueDropzone.removeAllFiles()
        },
        updateAdvertisement() {
            if (this.newImage !== '') {
                this.form.images.main = this.newImage
                this.filesRemove()

            }
            axios.put('api/admin/advertisement/' + this.form.id, this.form)
                .then(() => {
                    $('#AddNew').modal('hide')

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire(
                        this.$trans('strings.Updated'),
                        this.$trans('strings.The selected record has been updated'),
                        'success'
                    )
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {

                });
        },
    }
}
</script>

<style scoped>

</style>
