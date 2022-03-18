<template>
    <div class="item">
        <span class="time">{{ friend.date|myDate }}</span>
        <div class="dot bg-danger"></div>
        <div class="content">
            <h4 class="title">{{ $trans('strings.Your referral') }} - {{friend.name}}</h4>
            <div class="text">
                <img :src="'assets/sample/' +friend.avatar" alt="avatar" class="imaged w48 rounded">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserFriendsAddHistoryItem",
    props: {
        friend: {
            required: true,
            type: Object
        }
    }
}
</script>
