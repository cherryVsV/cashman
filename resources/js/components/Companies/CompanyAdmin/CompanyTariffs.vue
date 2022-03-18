<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{ $trans('strings.Tariffs and plans') }}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="container">
                <div class="row" v-if="plan!==null" style="display: flex;justify-content: center;margin: 2% 0 2% 0;">
                    <div class="col-md-4 col-sm-6" style="width: 100%;">
                        <h3 style="text-align: center;">{{ $trans('strings.Data about your current subscription') }}</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" class="table-primary">{{ $trans('strings.Name of the plan') }}</th>
                                <th scope="col" class="table-secondary">{{ $trans('strings.Price') }}</th>
                                <th scope="col" class="table-warning">
                                    {{ $trans('strings.Date of the next write-off') }}
                                </th>
                                <th scope="col" class="table-info">{{ $trans('strings.Subscription Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-primary">{{ plan.name }}</td>
                                <td class="table-secondary">{{ plan.sum }}₽</td>
                                <td class="table-warning">{{ plan.expired_at|myDate }}</td>
                                <td class="table-info">
                                    <button v-if="plan.is_active" type="button" class="btn btn-danger"
                                            @click="cancelSubscribe">{{ $trans('strings.Cancel') }}
                                    </button>
                                    <button v-if="!plan.is_active" type="button" class="btn btn-warning"
                                            @click="resumeSubscribe">{{ $trans('strings.Resume') }}
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;margin: 2% 0 2% 0;">
                    <h3 v-if="plan===null" style="text-align: center;">
                        {{ $trans('strings.Purchase a subscription and use all the amenities of our service!') }}</h3>
                    <h3 v-if="plan!==null" style="text-align: center;">
                        {{ $trans('strings.You can change the subscription plan according to your needs!') }}</h3>
                    <div class="col-md-4 col-sm-6" v-for="tariff in tariffs">
                        <div class="pricingTable">
                            <h3 class="title">{{ tariff.title }}</h3>
                            <div class="pricing-content">
                                <div class="amount">{{ tariff.money }}₽
                                    <span class="month">{{ $trans('strings./month.') }}</span>
                                </div>
                                <ul>
                                    <li v-for="property in JSON.parse(tariff.properties)">{{ property }}</li>
                                </ul>
                                <a href="#" class="pricingTable-signup" data-bs-toggle="modal"
                                   data-bs-target="#SubscribeModal"
                                   @click="setTariff(tariff.identifier)">{{ $trans('strings.Buy') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <SubscribeModal :intent="intent" :company="company"></SubscribeModal>
    </fragment>
</template>

<script>
import Header from "../../LayoutComponents/Header";
import SubscribeModal from "../../Modals/SubscribeModal";
import {eventBus} from '../../../app'

export default {
    name: "CompanyTariffs",
    components: {
        Header,
        SubscribeModal
    },
    props: ['company', 'tariffs', 'intent', 'current'],
    data() {
        return {
            tariff: null,
            plan: null
        }
    },
    mounted() {
        this.plan = this.current
        eventBus.$on('new-plan', (data) => {
            this.plan = data
        })
    },
    methods: {
        setTariff(plan) {
            eventBus.$emit('set-plan', plan)
        },
        cancelSubscribe() {
            axios.post('/api/payments/cancel', {
                company: this.company
            }).then((response) => {
                this.plan = response.data.plan
                Toast.fire({
                    icon: 'success',
                    title: this.$trans('strings.Record successfully added')
                });
            })
        },
        resumeSubscribe() {
            axios.post('/api/payments/resume', {
                company: this.company
            }).then((response) => {
                this.plan = response.data.plan
                Toast.fire({
                    icon: 'success',
                    title: this.$trans('strings.Record successfully added')
                });
            })
        }
    }
}
</script>

<style scoped>
.pricingTable {
    border: 1px solid #ddd;
    background: #6236FF;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover {
    background: #fff;
}

.pricingTable .title {
    font-size: 24px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    margin: 25px 0 25px 50px;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .title {
    color: #6236FF;
}

.pricingTable .pricing-content {
    padding: 40px 50px;
    margin: 0 30px 30px 0;
    background: #fff;
    text-align: center;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .pricing-content {
    background: #6236FF;
    color: #fff;
    box-shadow: 2px 2px 4px 2px #ddd;
}

.pricingTable .amount {
    font-size: 50px;
    font-weight: 700;
    color: #6236FF;
    text-align: center;
    margin-bottom: 20px;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .amount {
    color: #fff;
}

.pricingTable .month {
    font-size: 18px;
    color: #777;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .month {
    color: #fff;
}

.pricingTable .pricing-content ul {
    padding: 0;
    margin: 0 0 20px 0;
    list-style: none;
    text-align: left;
}

.pricingTable .pricing-content ul li {
    font-size: 15px;
    color: #333;
    line-height: 40px;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .pricing-content ul li {
    color: #fff;
}

.pricingTable .pricingTable-signup {
    display: inline-block;
    padding: 15px 25px;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 600;
    color: #333;
    overflow: hidden;
    text-transform: uppercase;
    border: 1px solid #ddd;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease 0s;
}

.pricingTable:hover .pricingTable-signup {
    color: #fff;
    border-color: #6236FF;
}

.pricingTable .pricingTable-signup:hover {
    color: #5f5b5b;
}

.pricingTable .pricingTable-signup:before,
.pricingTable .pricingTable-signup:after {
    content: "";
    width: 55%;
    height: 100%;
    background: #fff;
    position: absolute;
    top: 0;
    z-index: -1;
    transition: all 0.35s ease 0s;
}

.pricingTable .pricingTable-signup:before {
    left: -55%;
}

.pricingTable .pricingTable-signup:hover:before {
    left: 0;
}

.pricingTable .pricingTable-signup:after {
    right: -55%;
}

.pricingTable .pricingTable-signup:hover:after {
    right: 0;
}

@media only screen and (max-width: 990px) {
    .pricingTable {
        margin-bottom: 30px;
    }
}
</style>
