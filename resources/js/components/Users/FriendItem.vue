<template>
    <fragment>
        <div class="item">
            <img :src="'assets/sample/' +user.avatar" alt="image" class="imaged w86 rounded">
            <div class="in">
                <div>
                    <header>{{ $trans('strings.User') }}</header>
                    <header>{{ user.name }}</header>
                    <footer>{{ user.region }}</footer>
                </div>

            </div>
        </div>
    </fragment>
</template>

<script>
import ConfirmActionModal from "../Modals/ConfirmActionModal";

export default {
    name: "FriendItem",
    components: {ConfirmActionModal},
    props: {
        user:
            {
                required: true,
                type: Object
            }
    }
}
</script>

<style scoped>
.listview > li header, li footer {
    font-size: 16px !important;
    margin: 10% !important;
}
</style>
