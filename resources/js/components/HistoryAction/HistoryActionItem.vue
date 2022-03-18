<template>
    <a :href="'history/action-' + this.action.id" class="item">
        <div class="icon-box bg-primary">
            <img :src="'assets/sample/' + action.image" alt="image" class="imaged w48 rounded">
        </div>
        <div class="in">
            <div>
                <div class="mb-05"><strong>{{ action.notification_type }}</strong></div>
                <div class="text-small mb-05">{{ action.title}}</div>
                <div class="text-xsmall">{{ action.created_at|myDate() }}</div>
            </div>
            <span v-if="!action.is_seen" class="badge badge-primary badge-empty"></span>
        </div>
    </a>
</template>

<script>
export default {
    name: "HistoryActionItem",
    props: {
        action: {
            required: true,
            type: Object
        }
    }
}
</script>
