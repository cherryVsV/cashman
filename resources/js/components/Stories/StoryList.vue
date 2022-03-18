<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 class="title">{{ $trans('strings.Stories') }}</h2>
        </div>
        <!-- story-block -->
        <div class="mb-0 story-block splide">
            <splide :slides="stories" :options="options">
                <splide-slide v-if="addNew">
                    <a href="/add-advertising">
                        <img src="assets/icon/plus.png" alt="alt"
                             class="imaged w-100 rounded shadow-none">
                    </a>
                </splide-slide>
                <splide-slide v-for="story in stories" :key="story.id">
                    <StoryItem :story='story'></StoryItem>
                </splide-slide>
            </splide>
        </div>
        <!-- * story-block -->
        <StoryModal :story="currentStory"/>
    </div>
</template>

<script>
import StoryItem from "./StoryItem";
import {eventBus} from '../../app'
import StoryModal from "../Modals/StoryModal";
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "StoryList",
    components: {StoryModal, StoryItem, Splide, SplideSlide},
    props: {
        addNew: {
            default: false,
            type: Boolean
        },
        stories: {
            required: true,

        }
    },
    data: function () {
        return {
            currentStory: [],
            options: {
                perPage: 4,
                rewind: true,
                gap: 16,
                padding: 16,
                arrows: false,
                pagination: false,
                breakpoints: {
                    768: {
                        perPage: 2
                    },
                    991: {
                        perPage: 3
                    }
                }
            },
        }
    },
    mounted() {
        eventBus.$on('showStory', this.getCurrentStory)
    },
    methods: {
        getCurrentStory(story) {
            this.currentStory = story
        }
    }
}
</script>
