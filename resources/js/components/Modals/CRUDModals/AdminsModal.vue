<template>
    <div class="modal fade" id="AdminsModal" tabindex="-1" aria-labelledby="CashbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="operation==='Add'" class="modal-title">{{$trans('strings.Adding a company Administrator')}}</h5>
                    <h5 v-if="operation==='Delete'" class="modal-title">{{$trans('strings.Deleting a company administrator')}}</h5>
                </div>
                <form @submit.prevent="operation==='Add' ? addAdmin() : deleteAdmin()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{$trans('strings.User Code')}}</label>
                            <input v-model="form.user" type="text" name="user"
                                   :placeholder="$trans('strings.User Code')"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('user') }">
                            <HasError :form="form" field="user"></HasError>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{$trans('strings.Close')}}</button>
                        <button v-if="operation==='Add'" type="submit" class="btn btn-success" >{{$trans('strings.Add an Administrator')}}
                        </button>
                        <button v-if="operation==='Delete'" type="submit" class="btn btn-success">{{$trans('strings.Remove the administrator')}}
                        </button>
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
    name: "AdminsModal",
    components: {HasError},
    props: {
        operation: {
            required: true,
            type: String
        },
        company: {
            required: true
        }
    },
    data() {
        return {
            form: new Form({
                user: null,
                company: 0,
                lang: null
            })
        }
    },
    methods: {
        deleteAdmin() {
            this.form.company = this.company
            this.form.lang = localStorage.getItem('locale')
            this.form.post('api/delete/company/admin').then((response) => {
                $('#AdminsModal').modal('hide')
                this.form.user = null
                if (response.data.error !== undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: this.$trans('strings.The operation cannot be performed'),
                        text: this.$trans('strings.The selected user is not an administrator of the company'),
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: this.$trans('strings.The operation was successful!'),
                        text: this.$trans('strings.The administrator has been successfully removed'),
                    })
                }

            }).catch(() => {

            });
        },
        addAdmin() {
            this.form.company = this.company
            this.form.lang = localStorage.getItem('locale')
            this.form.post('api/add/company/admin').then(() => {
                $('#AdminsModal').modal('hide')
                this.form.user = null
                Swal.fire({
                    icon: 'success',
                    title: this.$trans('strings.The operation was successful!'),
                    text: this.$trans('strings.Administrator successfully added'),
                })
            }).catch(() => {

            });
        }
    }
}
</script>

<style scoped>

</style>
