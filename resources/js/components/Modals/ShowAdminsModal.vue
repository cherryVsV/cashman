<template>
    <div class="modal fade" id="ShowAdmins" tabindex="-1" aria-labelledby="CashbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">{{$trans('strings.Company Administrators')}}</h5>
                </div>
                <ul class="listview image-listview inset">
                    <li v-for="admin in admins">
                        <div class="item">
                            <img :src="'assets/sample/' + admin.avatar" alt="image" class="imaged w86 rounded">
                            <div class="in">
                                <div style="margin: 0 0 0 2%;">
                                    <header>{{ admin.name }}</header>
                                    <header>{{ admin.email }}</header>
                                    <footer>{{ admin.phone }}</footer>
                                </div>

                            </div>
                        </div>
                    </li>

                </ul>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{$trans('strings.Close')}}</button>

                </div>

            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "ShowAdminsModal",
    props: {
        admins: {
            required: true
        }
    }

}
</script>

<style scoped>

</style>
