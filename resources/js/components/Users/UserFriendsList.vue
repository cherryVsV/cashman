<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{ $trans('strings.Your friends') }}
            </template>
        </Header>
        <br/>

        <div id="appCapsule" class="full-height">
            <h4 class="text-center" v-if="friends.length===0">
                {{ $trans('strings.You haven\'t invited any friends yet. Invite friends to the company and get nice bonuses!') }}
            </h4>
            <div v-if="friends.length!==0" class="section inset mt-2 mb-2">
                <div class="accordion" id="accordionExample5">
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-primary">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordiond1">
                                {{ $trans('strings.History of adding friends') }}
                            </button>
                        </h2>
                        <div id="accordiond1" class="accordion-collapse collapse" data-bs-parent="#accordionExample5">
                            <div class="accordion-body">
                                <UserFriendsAddHistory :friends="friends"></UserFriendsAddHistory>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul v-if="friends!==null" class="listview image-listview inset">
                <li v-for="friend in friends">
                    <FriendItem :user=friend></FriendItem>
                </li>
            </ul>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import FriendItem from "./FriendItem";
import UserFriendsAddHistory from "./UserFriendsAddHistory";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";

export default {
    name: "UserFriendsList",
    components: {Footer, BottomMenu, UserFriendsAddHistory, FriendItem, Header},
    props: {
        friends: {
            required: true
        }
    }
}
</script>
