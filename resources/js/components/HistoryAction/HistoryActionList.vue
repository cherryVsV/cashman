<template>
    <div class="section mt-4">
        <div v-if="!showDetail" class="section-heading padding">
            <h2 class="title">{{$trans('strings.History of recent actions')}}</h2>
            <a href="history" class="link">{{$trans('strings.View all')}}</a>
        </div>
        <ul class="listview image-listview inset mx-1">
            <li v-for="action in actions">
                <HistoryActionItem :action=action></HistoryActionItem>
            </li>
        </ul>
    </div>
</template>

<script>
import HistoryActionItem from "./HistoryActionItem";

export default {
    name: "HistoryActionList",
    components: {HistoryActionItem},

    props: {
        showDetail: {
            required: true,
            type: Boolean
        },
        actions:{
            required: true
        }
    }
}
</script>
