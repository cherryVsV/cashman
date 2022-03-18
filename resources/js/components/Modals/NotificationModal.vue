<template>
    <div class="modal fade dialogbox" id="DialogNotification" data-bs-backdrop="static" tabindex="-1"
         role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div v-if="icon==='success'" class="modal-icon text-success">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div v-if="icon==='danger'" class="modal-icon text-danger">
                    <ion-icon name="close-circle"></ion-icon>
                </div>
                <div v-if="icon==='card'" class="modal-icon">
                    <ion-icon name="card-outline"></ion-icon>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">{{title}}</h5>
                </div>
                <div class="modal-body">
                    {{description}}
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn" data-bs-dismiss="modal">CLOSE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotificationModal",
    props: {
        title: {
            required: true,
            type: String
        },
        icon: {
            type: String
        },
        description: {
            required: true,
            type: String
        }
    }
}
</script>

<style scoped>

</style>
