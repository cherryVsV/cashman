<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Company Administrators')}}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section inset mt-2 mb-2">
                <ul class="listview image-listview inset">
                    <li v-for="admin in admins">
                        <div class="item">
                            <img :src="'assets/sample/' + admin.avatar" alt="image" class="imaged w86 rounded">
                            <div class="in">
                                <div style="margin: 0 0 0 2%;">
                                    <header>{{$trans('strings.Admin Code')}} - {{admin.id}}</header>
                                    <header>{{ admin.name }}</header>
                                    <footer>{{ admin.phone }}</footer>
                                </div>
                                <a v-if="!admin.isActive" href="#" class="headerButton">
                                    Online
                                </a>
                                <a v-if="admin.isActive" href="#" class="headerButton">
                                    Offline
                                </a>

                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </fragment>
</template>
<script>
import Header from "../../LayoutComponents/Header";
import FriendItem from "../../Users/FriendItem";

export default {
    name: "CompanyGroupAdmin",
    components: {FriendItem, Header},
    props: {
        admins: {
            required: true
        }
    }
}
</script>

<style scoped>
.listview > li header, li footer {
    font-size: 16px !important;
    margin: 8% 0 0 0 !important;
}
</style>
