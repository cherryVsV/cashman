<template>
    <fragment>
        <div class="in">
            <div>
                <h4>{{ achievement.achievement.title }}</h4>
                <p>{{ achievement.achievement.achievement_description }}</p>
            </div>
            <div class="price">
                <a :href="'achievements/achievements-' + achievement.id" v-if="showDetail" type="button"
                   class="btn btn-text-primary me-1 mb-1" @click="showAchievementDetail">{{$trans('strings.View')}}</a>
            </div>

        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" :style="'width:' + achievement.progress +'%;'" :aria-valuenow="achievement.progress"
                 aria-valuemin="0" aria-valuemax="100">{{ achievement.progress }} %
            </div>
        </div>
    </fragment>
</template>

<script>
export default {
    name: "AchievementItem",
    props: {
        achievement: {
            required: true,
            type: Object
        },
        showDetail: {
            required: true,
            type: Boolean
        }
    },
    methods: {
        showAchievementDetail() {
            axios.get('achievements/achievements-' + this.achievement.id)
        }
    }
}
</script>
