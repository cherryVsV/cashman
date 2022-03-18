<template>
    <div class="modal fade" id="ChangeAvatarModal" tabindex="-1" aria-labelledby="AddNewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ChangeAvatarLabel">{{$trans('strings.Changing the account photo')}}</h5>

                </div>
                <form @submit.prevent="changeAvatar">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{$trans('strings.Add a new photo')}}</label>
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
                            <HasError :form="form" field="avatar"></HasError>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{$trans('strings.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{$trans('strings.Update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import Form from "vform";
import {HasError} from "vform/src/components/bootstrap5";

export default {
    name: "ChangeAvatarModal",
    components: {HasError, vueDropzone: vue2Dropzone},
    props: {
        id: {
            required: true,
            type: Number
        }
    },
    data() {
        return {
            dropzoneOptions: {
                url: "api/avatars",
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            },
            form: new Form({
                id: null,
                avatar: ''
            }),
            image: ''
        }
    },
    methods: {
        uploadSuccess(file, response) {
            this.image = response.file;
        },

        fileRemoved() {
            this.image = ''
        },
        filesRemove() {
            this.$refs.myVueDropzone.removeAllFiles()
        },
        changeAvatar() {
            this.form.id = this.id
            if (this.image !== '') {
                this.form.avatar = this.image
                this.fileRemoved()
            }
            this.form.post('api/change/avatar').then((response) => {
                this.filesRemove()
                if (response.data.status === 'success') {
                    this.$emit('updateParent')
                    this.form.avatar = ''
                    $('#ChangeAvatarModal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: this.$trans('strings.The operation was successful!'),
                        text: this.$trans('strings.The avatar of your account has been successfully changed!'),
                    })
                }
                if (response.data.status === 'error') {
                    $('#ChangeAvatarModal').modal('hide')
                    Swal.fire({
                        icon: 'error',
                        title: this.$trans('strings.The operation cannot be performed'),
                        text: this.$trans('strings.You can\'t replace an avatar with the same photo'),
                    })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
