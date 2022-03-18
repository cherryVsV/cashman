<template>
    <div class="modal fade dialogbox" id="DialogIconedButtonInline" data-bs-backdrop="static" tabindex="-1"
         role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ action }}</h5>
                </div>
                <div class="modal-body">
                   {{$trans('strings.Are you sure? It will be impossible to cancel the action')}}
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-danger" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                            {{$trans('strings.Cancel')}}
                        </a>
                        <a href="#" class="btn btn-text-primary" data-bs-dismiss="modal"  @click="deleteAction()">
                            <ion-icon name="checkmark-outline"></ion-icon>
                            {{$trans('strings.Yes')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ConfirmActionModal",
    props: {
        action: {
            required: true,
            type: String
        },
        id:{
            required: true,
            type: Number
        }
    },
    methods:{
        deleteAction(){
            axios.delete('../api/action/delete/'+this.id).then(()=>{
                window.location.href = '/history';
            })
        }
    }
}
</script>
