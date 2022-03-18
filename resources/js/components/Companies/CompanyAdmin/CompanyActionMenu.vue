<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Action Menu')}}
            </template>
        </Header>
        <div class="section mt-2">
            <div class="section-title">Blocked</div>
            <div class="card">
                <div class="card-body">

                    <div class="mt-1"></div>

                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="showOffsCashBackModal">
                        {{$trans('strings.Debit CashBack')}}
                    </button>
                    <div class="mt-1"></div>

                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="showDebitingCashBackModal">
                        {{$trans('strings.Add CashBack')}} {{company.cashback_percent}}%
                    </button>
                    <div class="mt-1"></div>

                    <div class="mt-1"></div>

                    <button v-if="company.admins" type="button" class="btn btn-primary btn-lg btn-block" @click="showAddAdminModal">{{$trans('strings.Add an Administrator')}}
                    </button>
                    <div class="mt-1"></div>

                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="showDeleteAdminModal">{{$trans('strings.Remove the administrator')}}
                    </button>
                    <div class="mt-1"></div>

                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="terminate">{{$trans('strings.Finish the job')}}
                    </button>

                </div>
            </div>
        </div>
        <CashbackModal :company="company" :admin="admin" :user="user" :type="type"></CashbackModal>
        <AdminsModal :company="company" :operation="operation"></AdminsModal>
    </fragment>
</template>

<script>
import Header from "../../LayoutComponents/Header";
import CashbackModal from "../../Modals/CashbackModal";
import {eventBus} from "../../../app";
import AdminsModal from "../../Modals/CRUDModals/AdminsModal";

export default {
    name: "CompanyActionMenu",
    components: {AdminsModal, CashbackModal, Header},
    props: {
        company: {
            required: true
        },
        admin: {
            required: true,
            type: Number
        }
    },
    data() {
        return {
            user: 0,
            type: null,
            operation: ''
        }
    },
    methods: {
        showDebitingCashBackModal() {
            this.type = 'Начисление'
            $('#CashbackModal').modal('show');
        },
        showOffsCashBackModal() {
            this.type = 'Списание'
            $('#CashbackModal').modal('show');
        },
        showAddAdminModal() {
            this.operation = 'Add'
            $('#AdminsModal').modal('show');
        },
        showDeleteAdminModal() {
            this.operation = 'Delete'
            $('#AdminsModal').modal('show');
        },
        terminate() {
            window.location.href = '/user-profile'
        }
    },
    mounted() {
        let param = location.search
        if (param.length > 0) {
            this.type = 'Начисление'
            //this.user = param.slice(param.indexOf('=')+1)
            //console.log(this.user)
            eventBus.$emit('userId', param.slice(param.indexOf('=') + 1))
            $('#CashbackModal').modal('show');
        }

    }
}
</script>

<style scoped>

</style>
