<template>
    <ul class="comment-list">
        <Comment :key="comment.id" v-for="comment in comments" :comment="comment"></Comment>
    </ul>
</template>

<script>
import {mapGetters} from 'vuex'
import Comment from './Comment'

export default {
    name: "Comments",
    components: {Comment},
    props: ['id'],
    mounted() {
        this.$store.dispatch('GET_COMMENTS', this.id)

        window.Echo.channel('comment-channel')
            .listen('.newComment', (data) => {
                this.$store.commit('ADD_COMMENT', data.comment)
            })
    },
    computed: {
        ...mapGetters([
            'comments'
        ])
    }
}
</script>

<style scoped>
.comment-list {
    padding: 1em 0;
    margin-bottom: 15px;
}

</style>
