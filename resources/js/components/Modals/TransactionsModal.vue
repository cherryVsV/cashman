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
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <slot name="first">
                                        <label class="label" for="account2d">{{$trans('strings.From')}}</label>
                                        <input v-model="form.from" type="email" class="form-control" id="account2d"
                                               placeholder="Enter IBAN">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </slot>
                                    <HasError :form="form" field="from"/>
                                </div>
                            </div>
                            <div v-if="recipient && exchange===false" class="form-group basic">
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
                            <div v-if="exchange ===true" class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="currency1">{{$trans('strings.From')}}</label>
                                    <select class="form-control custom-select" id="currency1">
                                        <option value="1">EUR</option>
                                        <option value="2">USD</option>
                                        <option value="3">AUD</option>
                                        <option value="4">CAD</option>
                                    </select>
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
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
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
                from: '',
                to: '',
                amount: ''
            })
        }
    },
    methods: {
        async buySubscription() {
            await this.form.post('api/buy/subscription')
        },
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
