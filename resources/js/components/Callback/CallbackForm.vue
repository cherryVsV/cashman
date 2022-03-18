<template>
    <div class="section mt-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="p-1">
                    <div class="text-center">
                        <h2 class="text-primary">{{$trans('strings.Write to us')}}</h2>
                        <p>{{$trans('strings.Fill out this form to start communication')}}</p>
                    </div>
                    <AlertErrors :form="form" class="mb-2"></AlertErrors>
                    <form @submit="sendMessage"
                          @keydown="form.onKeydown($event)">
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="name2">{{$trans('strings.Please provide your name.')}}</label>
                                <input v-model="form.name" type="text" class="form-control" id="name2"
                                       :placeholder="$trans('strings.Please provide your name.')">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="name"/>
                        </div>
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="email2">{{$trans('strings.Phone number')}}</label>
                                <input v-model="form.phone" type="text" class="form-control" id="email2"
                                       :placeholder="$trans('strings.Phone number')">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="phone"/>
                        </div>
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="textarea2">{{$trans('strings.Message')}}</label>
                                <textarea v-model="form.message" id="textarea2" rows="4" class="form-control"
                                          :placeholder="$trans('strings.Message')"></textarea>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <HasError :form="form" field="message"/>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <h4 class="text-center">{{$trans('strings.Select messengers to respond to')}}</h4>
                                <ul class="messagers">
                                    <li>

                                        <input type="checkbox" id="telegram-check" name="answer-check" v-model="socials"
                                               value="telegram">
                                        <label for="telegram-check">
                                            <i class="fab fa-telegram-plane"></i>
                                        </label>
                                    </li>
                                    <li>

                                        <input type="checkbox" id="viber-check" name="answer-check" value="viber"
                                               v-model="socials">
                                        <label for="viber-check">
                                            <i class="fab fa-viber"></i>
                                        </label>

                                    </li>
                                    <li>

                                        <input type="checkbox" id="whatsapp-check" name="answer-check" value="whatsapp"
                                               v-model="socials">
                                        <label for="whatsapp-check">
                                            <i class="fab fa-whatsapp"></i>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <VoiceCallbackForm :phone="form.phone" :cansend="cansend"></VoiceCallbackForm>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">{{$trans('strings.Send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform"
import {AlertErrors, HasError} from "vform/src/components/bootstrap5"
import VoiceCallbackForm from "./VoiceCallbackForm";

export default {
    name: "CallbackForm",
    components: {VoiceCallbackForm, AlertErrors, HasError},
    data: function () {
        return {
            socials: [],
            form: new Form({
                name: '',
                phone: '',
                message: ''
            }),
            cansend: false,
        }
    },
    methods: {
        sendMessage(e) {
            e.preventDefault();
            this.cansend = true;
            axios
                .post('api/send/message', {
                    phone: this.form.phone,
                    name: this.form.name,
                    message: "</b>:\n" + this.form.message + "\n" + "\nМожно связаться в: " + JSON.stringify(this.socials),

                })
                .then(() => {
                    this.sendMessage("Сообщение успешно отправлено");
                    this.form.name = "";
                    this.form.phone = "";
                    this.form.message = "";
                    this.socials = [];
                    this.cansend = false;
                })
        },
    }
}
</script>
<style lang="scss">
.messagers {
    display: flex;
    justify-content: center;
    padding: 0;
    margin: 0;

    li {
        list-style: none;
        padding: 10px;

        label {
            width: 70px;
            height: 70px;
            background: #fff;
            border: 3px solid #d3d3d3;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #d3d3d3;
            font-size: 28px;
        }

        input {
            display: none;
        }

        input:checked ~ label {
            border: 3px #6e20c9 solid;
            color: #9851bd;
        }

    }


}
</style>
