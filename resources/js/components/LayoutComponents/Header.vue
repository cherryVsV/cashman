<template>
    <div class="appHeader">
        <div class="left">
            <slot name="left"></slot>
        </div>
        <div class="pageTitle">
            <slot name="title"></slot>
        </div>
        <div class="right">
            <slot name="right"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    methods: {
        getNot() {
            let vm = this
            messaging.onMessage(function (payload) {
                const note = payload.data.title.split(',');
                const noteTitle = note[0]
                const noteOptions = {
                    body: payload.data.body,
                    icon: payload.data.image,
                };
                new Notification(noteTitle, noteOptions);
                vm.$dtoast.pop({
                    preset: note[1],
                    heading: noteTitle,
                    content: payload.data.body,
                })
            });
        },
    },
    mounted() {
        this.getNot()
    }
}

</script>
