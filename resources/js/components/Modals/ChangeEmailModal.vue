<template>
    <div class="modal fade" id="ChangeEmailModal" tabindex="-1" aria-labelledby="CashbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$trans('strings.Changing account email')}}</h5>
                </div>
                <form @submit.prevent="changeEmail">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{$trans('strings.New Mail')}}</label>
                            <input v-model="form.email" type="email" name="email"
                                   :placeholder="$trans('strings.New Mail')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <HasError :form="form" field="email"></HasError>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{$trans('strings.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{$trans('strings.Change Email')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";
import {HasError} from "vform/src/components/bootstrap5"

export default {
    name: "ChangeEmailModal",
    components: {HasError},
    props: {
        id: {
            required: true,
            type: Number
        }
    },
    data() {
        return {
            form: new Form({
                id: null,
                email: ''
            })
        }
    },
    methods: {
        changeEmail() {
            this.form.id = this.id
            this.form.post('api/change/email').then((response) => {
                if (response.data.status === 'success') {
                    this.form.email = ''
                    $('#ChangeEmailModal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: this.$trans('strings.The operation was successful!'),
                        text: this.$trans('strings.Your account\'s email has been changed to') + this.form.email,
                    })
                }
            })

        }
    }
}
</script>

<style scoped>

</style>
