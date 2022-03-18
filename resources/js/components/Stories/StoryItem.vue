<template>
    <a href="#" v-on:click="showStory(story)" class="item" data-bs-toggle="modal" data-component="stories"
       data-bs-target="#StoryDefault">
        <img :src="'./../assets/sample/'+story.avatar" alt="alt"
             class="imaged w-100 rounded">
    </a>
</template>
<script>
import {eventBus} from '../../app'

export default {
    name: "StoryItem",
    props: {
        story: {
            required: true,
        }
    },
    methods: {
        showStory(story) {
            eventBus.$emit('showStory', story)
        }
    }
}
</script>
