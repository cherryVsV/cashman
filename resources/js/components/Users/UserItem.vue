<template>
    <div class="bill-box users-item">
        <div class="img-wrapper">
            <img :src="'assets/sample/' +user.avatar" alt="img" class="image-block imaged w-100 images-users">
        </div>
        <strong>{{ user.name }}</strong>
    </div>
</template>

<script>
export default {
    name: "UserItem",
    props: {
        user:
            {
                required: true,
                type: Object
            },
    }
}
</script>
<style>
.images-users {
    object-fit: contain;
}
.users-item{
    height: 200px;
}
.bill-box {
    padding: 8px 12px;
}
.bill-box .img-wrapper {
    margin-bottom: 10px;
}
.bill-box strong {
    margin: 0 0 6px 0;
}
</style>
