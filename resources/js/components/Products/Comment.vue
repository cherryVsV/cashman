<template>
    <li class="comment-wrapper animate slideInLeft ">
        <div class="profile">
            <img :src="'/assets/sample/'+ comment.avatar" alt="" class="imaged rounded"></div>
        <div class="msg has-shadow">
            <div class="msg-body"><p class="name">{{comment.author}} <span class="date">{{comment.created_at | myDate}}</span></p>
                <p class="content">{{comment.content}}</p></div>
        </div>
    </li>
</template>

<script>
export default {
    name: "Comment",
    props: ['comment']
}
</script>

<style lang="scss" scoped>

.comment-wrapper {
    display: flex;
    list-style: none;
    text-align: left;
    overflow: hidden;
    margin-bottom: 2em;
    padding: .4em;

    .profile {
        width: 80px;
        height: 80px;
        float: left;
        margin-right: 2%;
        margin-left: 2%;

        img {
            width: 100%;
            height: 100%;
        }
    }

    .msg-body {
        padding: .8em;
        color: #666;
        line-height: 1.5;
    }

    .msg {
        flex: 1;
        float: left;
        background-color: #fff;
        border-radius: 0 5px 5px 5px;
        position: relative;
        margin-right: 2%;

        &::after {
            content: " ";
            position: absolute;
            left: -13px;
            top: 0;
            border: 14px solid transparent;
            border-top-color: #fff;
        }
    }

    .date {
        float: right;
    }
    .name {
        margin: 0;
        color: #999;
        font-weight: 700;
        font-size: .8em;
    }

    p:last-child {
        margin-top: .6em;
        margin-bottom: 0;
    }

}

@media (max-width: 439.98px) {
    .comment-wrapper .profile {
        width: 40px;
        height: 40px;
    }
}
</style>
