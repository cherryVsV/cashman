<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 v-if="all" class="title">{{$trans('strings.Activity history')}}</h2>
            <a v-if="all" href="/activity-history" class="link">{{$trans('strings.View all')}}</a>
        </div>
        <div class="transactions mx-3">
            <a href="#" class="item" v-for="item in actions">
                <ActivityHistoryItem :activity=item></ActivityHistoryItem>
            </a>
        </div>
    </div>
</template>

<script>
import ActivityHistoryItem from "./ActivityHistoryItem";

export default {
    name: "ActivityHistoryList",
    components: {ActivityHistoryItem},
    props: {
        actions: {
            required: true
        },
        all: {
            default: true,
            type: Boolean
        }
    }
}
</script>
