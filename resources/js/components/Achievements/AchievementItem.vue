<template>
    <fragment>
        <div class="in">
            <div>
                <h4>{{ achievement.title }}</h4>
                <p>{{ achievement.achievement_description }}</p>
            </div>
            <div class="price">$ {{ achievement.value }}
                <a :href="'achievements/achievements-' + this.achievement.id" v-if="showDetail" type="button"
                   class="btn btn-text-primary me-1 mb-1" @click="showAchievementDetail">{{$trans('strings.View')}}}</a>
            </div>

        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85"
                 aria-valuemin="0" aria-valuemax="100">{{ achievement.position }} %
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
