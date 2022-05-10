<template>
    <fragment>
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">{{ $trans('strings.Total cashback') }}</span>
                        <h1 class="total">{{ $trans('strings.$') }} {{ profile.score }}</h1>
                    </div>
                    <div class="right">
                        <a href="#" class="button" data-bs-toggle="modal" data-bs-target="#depositActionSheet">
                            <ion-icon name="add-outline"></ion-icon>
                        </a>
                    </div>
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    <div class="item" v-for="action in actions">
                        <StatisticAction :icon=action.icon
                                         :title=action.title
                                         :link=action.link
                                         :exchange=action.exchange></StatisticAction>
                    </div>
                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <div class="section">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">{{ $trans('strings.Accruals') }}</div>
                        <div class="value text-success">{{profile.debitings}} {{ $trans('strings.$') }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">{{ $trans('strings.Write-downs') }}</div>
                        <div class="value text-danger">{{profile.offs}} {{ $trans('strings.$') }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">{{ $trans('strings.Withdrawal') }}</div>
                        <div class="value">{{profile.payouts}} {{ $trans('strings.$') }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">{{ $trans('strings.Transfer') }}</div>
                        <div class="value text-info">{{profile.sendings}} {{ $trans('strings.$') }}</div>
                    </div>
                </div>

            </div>
        </div>

        <TransactionsModal :title="currentTitle" :exchange=currentExchange></TransactionsModal>
        <TransactionsModal :title="$trans('strings.Increase in total cashback')" modalID="depositActionSheet"
                           :recipient=false></TransactionsModal>
    </fragment>
</template>

<script>
import StatisticAction from "./StatisticAction";
import {eventBus} from "../../app";
import TransactionsModal from "../Modals/TransactionsModal";

export default {
    name: "StatisticsSummary",
    components: {StatisticAction, TransactionsModal},
    props: {
        profile: {
            required: true,
        }
    },
    data: function () {
        return {
            actions: [
                {icon: 'withdraw', title: 'Вывод', exchange: true},
                {icon: 'send', title: 'Отправка'},
                {icon: 'history', title: 'История', link: '/history'},
            ],
            currentTitle: '',
            currentExchange: false,
        }
    },
    mounted() {
        eventBus.$on('showModal', this.getCurrentModal)
    },
    methods: {
        getCurrentModal(title, exchange) {
            this.currentTitle = title
            this.currentExchange = exchange
        }
    }
}
</script>
<style scoped>
.stat-box {
    margin: 1% !important;
}
</style>
