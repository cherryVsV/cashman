<template>
    <div class="section mt-4">
        <div v-if="!showDetail" class="section-heading padding">
            <h2 class="title">{{$trans('strings.Achievements')}}</h2>
            <a href="achievements" class="link">{{$trans('strings.View all')}}</a>
        </div>
        <div class="goals">
            <div class="item" v-for="achievement in achievements">
                <AchievementItem :achievement=achievement
                                 :show-detail=showDetail></AchievementItem>
            </div>
        </div>
    </div>
</template>

<script>
import AchievementItem from "./AchievementItem";

export default {
    name: "AchievementList",
    components: {AchievementItem},
    data: function () {
        return {
            achievements: [
                {
                    id: 1,
                    title: "Gaming Console",
                    achievement_description: "Gaming",
                    achievement_image_url: "assets/sample/photo/wide1.jpg",
                    value: 499,
                    prize_description: "Gaming Console",
                    prize_image_url: "assets/sample/photo/wide2.jpg",
                    position: 85
                },
                {
                    id: 2,
                    title: "Gaming Console",
                    achievement_description: "Gaming",
                    achievement_image_url: "assets/sample/photo/wide1.jpg",
                    value: 499,
                    prize_description: "Gaming Console",
                    prize_image_url: "assets/sample/photo/wide2.jpg",
                    position: 85
                },
                {
                    id: 3,
                    title: "Gaming Console",
                    achievement_description: "Gaming",
                    achievement_image_url: "assets/sample/photo/wide1.jpg",
                    value: 499,
                    prize_description: "Gaming Console",
                    prize_image_url: "assets/sample/photo/wide2.jpg",
                    position: 85
                },
                {
                    id: 4,
                    title: "Gaming Console",
                    achievement_description: "Gaming",
                    achievement_image_url: "assets/sample/photo/wide1.jpg",
                    value: 499,
                    prize_description: "Gaming Console",
                    prize_image_url: "assets/sample/photo/wide2.jpg",
                    position: 85
                },
            ]
        }
    },
    props: {
        showDetail: {
            required: true,
            type: Boolean
        }
    }
}
</script>
