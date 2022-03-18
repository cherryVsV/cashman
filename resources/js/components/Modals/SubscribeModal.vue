<template>
    <div class="modal fade action-sheet" id="SubscribeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <slot name="header">
                        <h5 class="modal-title">{{ $trans('strings.Buy a subscription') }}</h5>
                    </slot>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form>
                            <input type="hidden" name="plan" id="plan" :value="plan">
                            <div class="form-group basic">
                                <div class="form-group">
                                    <label for="card-holder-name">{{$trans('strings.Name')}}</label>
                                    <input type="text" name="name" id="card-holder-name" class="form-control" value="" :placeholder="$trans('strings.Name on the card')">
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="form-group">
                                    <label for="card-element" class="leading-7 text-sm text-gray-600">{{$trans('strings.Credit Card Info')}}</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <slot name="button">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"  @click="processPayment"
                                            data-bs-dismiss="modal">{{ $trans('strings.Buy a subscription') }}
                                    </button>
                                </slot>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { loadStripe } from '@stripe/stripe-js';
import {eventBus} from '../../app'
export default {
    name: "SubscribeModal",
    props:['intent','company'],
    components:{
        loadStripe,
    },
    data(){
        return {
            stripeAPIToken: 'pk_test_51KPoIxCA9Kju48lCXtQcmSTdaXyFipsjzOqgv2hzVW6Vucv7TURu4VWMVFGyShJChqOhJEjC7VzZumJYlNEqdBkm00Isneq3dV',
            cardElement: {},
            plan: null
        }
    },
    async mounted() {
        this.stripe = await loadStripe(this.stripeAPIToken);
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
            }
        });
        this.cardElement.mount('#card-element');
        eventBus.$on('set-plan', (data)=>{
            this.plan = data
        })
    },
    methods:{
        async processPayment() {
            const cardHolderName = document.getElementById('card-holder-name')
            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        name: cardHolderName.value,
                    }
                }
            );
            if (error) {
                console.error(error);
                await Toast.fire({
                    icon: 'error',
                    title: this.$trans('strings.Record successfully added')
                });
            } else {
                console.log(paymentMethod);
                await axios.post('/api/payments', {
                    token: paymentMethod.id,
                    company: this.company,
                    plan: this.plan
                }).then((response)=>{
                    let plan = response.data.plan
                    eventBus.$emit('new-plan', plan)
                    Toast.fire({
                        icon: 'success',
                        title: this.$trans('strings.Record successfully added')
                    });

                })

            }
        }

    },

}

</script>

<style scoped>

</style>
