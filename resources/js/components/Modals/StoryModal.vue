<template>
    <div class="modal fade stories" id="StoryDefault" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="story-image">
                    <img :src="'./../assets/sample/'+story.images.main" alt="image">
                </div>
                <div class="modal-header">
                    <a href="#" class="profile-detail">
                        <img :src="'./../assets/sample/'+story.avatar" alt="avatar"
                             class="imaged w36 rounded me-1">
                        <div>
                            <h4>{{ story.name }}</h4>
                            <span class="text-muted">{{ story.created_at | myDate}}</span>
                        </div>
                    </a>
                    <a href="#" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body flex-column justify-content-between padding-1-2-5-2">
                    <h1 class="bg-dark">{{ story.title }}</h1>
                    <p class="bg-dark">{{ story.description }}</p>
                    <a href="#" class="fixed-btn btn btn-primary">Button</a>
                </div>
            </div>
        </div>
    </div>
    <!-- * Story with Fixed Button  -->
</template>

<script>
export default {
    name: "StoryModal",
    props: {
        story: {
            required: true
        }
    }
}
</script>
<style>
.padding-1-2-5-2 {
    padding: 1% 2% 5% 2% !important;
}
</style>
