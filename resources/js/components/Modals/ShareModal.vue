<template>
    <div class="modal fade action-sheet inset" id="actionSheetShare" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$trans('strings.Share with')}}</h5>
                </div>
                <div class="modal-body">
                    <ul class="action-button-list social-icons" id="social-icons-modal">
                        <li>
                            <a href="#" class="btn btn-list" data-bs-dismiss="modal" data-type="vk" :data-url="url">
                                <span>
                                    <ion-icon name="logo-vk"></ion-icon>
                                    ВКонтакте
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-list" data-bs-dismiss="modal" data-type="ok" :data-url="url">
                                <span>
                                    <ion-icon src="/assets/icon/ok_logo.svg"></ion-icon>
                                    Одноклассники
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {shareSocials} from "../../shareSocials";
import {eventBus} from "../../app";

export default {
    name: "ShareModal",
    mixins: [shareSocials],
    data() {
        return {
            url: null
        }
    },
    mounted() {
        eventBus.$on('share-product', (data) => {
            this.url = data
            this.share("#social-icons-modal")
        })
    }
}
</script>
