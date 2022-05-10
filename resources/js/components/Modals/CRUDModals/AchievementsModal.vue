<template>
    <div class="modal fade" id="AddNew" tabindex="-1" aria-labelledby="AddNewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="AddNewLabel">
                        {{ $trans('strings.Add a new achievement') }}</h5>
                    <h5 class="modal-title" v-show="editmode" id="UpdateLabel">
                        {{ $trans('strings.Edit an achievement entry') }}</h5>

                </div>
                <form @submit.prevent="editmode ? updateAchievement() : createAchievement()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{$trans('strings.Achievement Title')}}</label>
                            <input v-model="form.title" type="text" name="title"
                                   :placeholder="$trans('strings.Achievement Title')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <HasError :form="form" field="title"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Achievement Description') }}</label>
                            <input v-model="form.achievement_description" type="text" name="achievement_description"
                                   :placeholder="$trans('strings.Achievement Description')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <HasError :form="form" field="achievement_description"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Achievement Image') }}</label>
                            <img v-if="editmode" :src="'/assets/sample/'+form.achievement_image_url" alt="achievement_image" class="imaged w100">
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
                            <HasError :form="form" field="achievement_image_url"></HasError>
                        </div>

                        <div class="form-group">
                            <label>{{ $trans('strings.Product') }}</label>
                            <input v-model="form.value" type="number" name="value"
                                   :placeholder="$trans('strings.Product')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('product') }">
                            <HasError :form="form" field="value"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Amount') }}</label>
                            <input v-model="form.position" type="number" name="position"
                                   :placeholder="$trans('strings.Amount')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                            <HasError :form="form" field="position"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Achievement Prize Description') }}</label>
                            <input v-model="form.prize_description" type="text" name="prize_description"
                                   :placeholder="$trans('strings.Achievement Prize Description')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('prize_desc') }">
                            <HasError :form="form" field="prize_description"></HasError>
                        </div>
                        <div class="form-group">
                            <label>{{ $trans('strings.Achievement Prize Image') }}</label>
                            <img v-if="editmode" :src="'/assets/sample/'+form.prize_image_url" alt="image" class="imaged w100">
                            <vue-dropzone
                                ref="myVueDropzonePrize"
                                id="dropzone1"
                                :options="dropzoneOptions"
                                :useCustomSlot="true"
                                v-on:vdropzone-success="uploadSuccessPrize"
                                v-on:vdropzone-removed-file="fileRemovedPrize"
                            >
                                <div class="dropzone-custom-content">
                                    <h3 class="dropzone-custom-title">
                                        {{ $trans('strings.Drag and drop to upload content!') }}</h3>
                                    <div class="subtitle">
                                        {{ $trans('strings.or click to select a file from your computer') }}
                                    </div>
                                </div>
                            </vue-dropzone>
                            <HasError :form="form" field="prize_image_url"></HasError>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            {{ $trans('strings.Close') }}
                        </button>
                        <button v-show="editmode" type="submit" class="btn btn-success">{{ $trans('strings.Update') }}
                        </button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">
                            {{ $trans('strings.Create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {HasError} from "vform/components/bootstrap5";
import vue2Dropzone from "vue2-dropzone";

export default {
    name: "AchievementsModal",
    components: {HasError, vueDropzone: vue2Dropzone},
    props: {
        form: {
            required: true
        },
        editmode: {
            required: true
        },
        id: {}
    },
    data() {
        return {
            dropzoneOptions: {
                url: 'api/add-achievement-image',
                acceptedFiles: ".png, .jpg, .jpeg",
                addRemoveLinks: true,
                maxFiles: 1
            },
            newImage: '',
            newPrizeImage: ''
        }
    },
    methods: {
        updateAchievement() {
            if (this.newImage !== '') {
                this.form.achievement_image_url = this.newImage
                this.filesRemove()

            }
            if (this.newPrizeImage !== '') {
                this.form.prize_image_url = this.newPrizeImage
                this.filesRemovePrize()

            }
            this.form.put('api/admin/achievements/' + this.form.id)
                .then(() => {
                    $('#AddNew').modal('hide');
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
        createAchievement() {
            this.form.achievement_image_url = this.newImage
            this.form.prize_image_url = this.newPrizeImage
            this.form.id = this.id
            this.filesRemove()
            this.form.post('api/admin/achievements')
                .then(() => {
                    Fire.$emit('AfterCreate');

                    $('#AddNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: this.$trans('strings.Record successfully added')
                    });
                })
                .catch(() => {
                    Toast.fire({
                        icon: 'error',
                        title: this.$trans('strings.The operation cannot be performed'),
                        text: this.$trans('strings.The selected product is not an item of the company'),
                    });
                })
        },
        uploadSuccess(file, response) {
            this.newImage = 'achievements/' + response.file;
        },
        fileRemoved() {
            this.newImage = ''
        },
        filesRemove() {
            this.$refs.myVueDropzone.removeAllFiles()
        },
        uploadSuccessPrize(file, response) {
            this.newPrizeImage = 'achievements/' + response.file;
        },
        fileRemovedPrize() {
            this.newPrizeImage = ''
        },
        filesRemovePrize() {
            this.$refs.myVueDropzonePrize.removeAllFiles()
        }

    }
}
</script>

<style scoped>

</style>
