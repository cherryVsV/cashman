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
    props: {
        showDetail: {
            required: true,
            type: Boolean
        },
        achievements:{
            required: true
        }
    }
}
</script>
