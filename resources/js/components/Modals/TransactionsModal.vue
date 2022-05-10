<template>
    <div class="modal fade action-sheet" :id=modalID tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <slot name="header">
                        <h5 class="modal-title">{{ title }}</h5>
                    </slot>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form @submit.prevent="buySubscription"
                              @keydown="form.onKeydown($event)">
                            <div v-if="recipient" class="form-group basic">
                                <div class="input-wrapper">
                                    <slot name="second">
                                        <label class="label" for="text11d">{{$trans('strings.To')}}</label>
                                        <input v-model="form.to" type="email" class="form-control" id="text11d"
                                               placeholder="Enter IBAN">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </slot>
                                    <HasError :form="form" field="to"/>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <slot name="third">
                                    <label class="label">{{$trans('strings.Enter Amount')}}</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addonb1">$</span>
                                        <input v-model="form.amount" type="text" class="form-control"
                                               :placeholder="$trans('strings.Enter Amount')"
                                               value="100">
                                    </div>
                                </slot>
                                <HasError :form="form" field="amount"/>
                            </div>
                            <div class="form-group basic">
                                <slot name="button">
                                    <button type="button" class="btn btn-primary btn-block btn-lg" @click="makeInvoice"
                                            data-bs-dismiss="modal">{{ title }}
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
import Form from "vform"
import {AlertErrors, HasError} from "vform/src/components/bootstrap5"

export default {
    name: "TransactionsModal",
    components: {HasError, AlertErrors},
    data: function () {
        return {
            form: new Form({
                to: '',
                amount: ''
            })
        }
    },
    methods: {
        async buySubscription() {
            await this.form.post('api/buy/subscription')
        },
        makeInvoice(){
            if(this.recipient && !this.exchange) {
              this.form.post('/send-cashback').then((res)=>{
                  if(res.data.status === 'success'){
                      Swal.fire({
                          icon: 'success',
                          title: this.$trans('strings.The operation was successful!'),
                          text: this.$trans('strings.The transfer was successfully completed'),
                      });
                      this.form.to = ''
                      this.form.amount = ''
                  }else{
                      Swal.fire({
                          icon: 'error',
                          title: this.$trans('strings.The operation cannot be performed'),
                          text: this.$trans('strings.Insufficient funds for the transfer'),
                      });
                  }
              })
            }else if(this.recipient && this.exchange){
                this.form.post('/paypal/payout').then((res)=>{
                    if(res.data.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: this.$trans('strings.The operation was successful!'),
                            text: this.$trans('strings.The transfer was successfully completed'),
                        });
                        this.form.to = ''
                        this.form.amount = ''
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: this.$trans('strings.The operation cannot be performed'),
                            text: this.$trans('strings.Insufficient funds for the payout'),
                        });
                    }
                })
            }
            else{
                window.location = '/paypal/express-checkout/' + this.form.amount
                this.form.to = ''
                this.form.amount = ''
            }
        }
    },
    props:
        {
            title: {
                required: true,
                type: String
            },
            recipient: {
                default: true,
                type: Boolean
            },
            exchange: {
                default: false,
                type: Boolean
            },
            modalID: {
                type: String,
                default: "withdrawActionSheet"
            }
        }
}
</script>
