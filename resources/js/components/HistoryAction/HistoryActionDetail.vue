<template>
    <fragment>
        <Header class="border-0">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:right>
                <a href="javascript:;" class="headerButton" data-bs-toggle="modal"
                   data-bs-target="#DialogIconedButtonInline">
                    <ion-icon name="trash-outline"></ion-icon>
                </a>
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2 mb-2">
                <div class="listed-detail mt-3">
                    <div class="icon-wrapper">
                        <div class="iconbox">
                            <img :src="'../assets/sample/' + action.image" alt="image" class="imaged w76 rounded">
                        </div>
                    </div>
                    <h3 class="text-center mt-2">{{ action.title }}</h3>
                </div>
                <ul class="listview simple-listview no-space mt-3">
                    <li>
                        <span>{{$trans('strings.Description')}}</span>
                        <strong class="h-100" v-html="action.description"></strong>
                    </li>
                    <li>
                        <span>{{$trans('strings.Date')}}</span>
                        <strong>{{ action.created_at|myDate() }}</strong>
                    </li>
                    <li>
                        <span>{{$trans('strings.Type')}}</span>
                        <strong>{{ action.notification_type }}</strong>
                    </li>
                </ul>
            </div>
        </div>
        <BottomMenu></BottomMenu>
        <ConfirmActionModal :action="$trans('strings.Remove') + action.title + $trans('strings.from the history of actions?') " :id="action.id"></ConfirmActionModal>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import BottomMenu from "../LayoutComponents/BottomMenu";
import ConfirmActionModal from "../Modals/ConfirmActionModal";

export default {
    name: "HistoryActionDetail",
    components: {ConfirmActionModal, BottomMenu, Header},
    props: {
        action: {
            required: true,
            type: Object
        }
    },
    mounted() {
        document.querySelector('body').classList.add('bg-white');
    }
}
</script>
