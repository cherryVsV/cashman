<template>
    <fragment>
        <Header class="border-0">
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Achievement')}} — {{ achievement.title }}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2 mb-2">
                <div class="listed-detail mt-3">
                    <div class="icon-wrapper">
                        <div class="iconbox">
                            <img :src="achievement.achievement_image_url" alt="image" class="imaged w76 rounded">
                        </div>
                    </div>
                    <h3 class="text-center mt-2">{{ achievement.title }}</h3>
                </div>
                <ul class="listview simple-listview no-space mt-3">
                    <li>
                        <strong>{{$trans('strings.Position')}}</strong>
                        <span class="text-success">{{ achievement.position }}</span>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Description')}}</strong>
                        <span>{{ achievement.description }}</span>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Prize image')}}</strong>
                        <div class="icon-wrapper">
                            <div class="iconbox">
                                <img :src="achievement.prize_image_url" alt="image" class="imaged w200 square">
                            </div>
                        </div>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Prize Description')}}</strong>
                        <span>{{ achievement.prize_description }}</span>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Active')}}</strong>
                        <span>{{$trans('string.Yes')}}</span>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Date')}}</strong>
                        <span>{{ achievement.created_at }}</span>
                    </li>
                    <li>
                        <strong>{{$trans('strings.Amount')}}</strong>
                        <h3 class="m-0">$ {{ achievement.value }}</h3>
                    </li>
                </ul>
            </div>
        </div>
        <Footer class="padding-bottom-70"></Footer>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import Header from "../LayoutComponents/Header";
import BottomMenu from "../LayoutComponents/BottomMenu";
import Footer from "../LayoutComponents/Footer";

export default {
    name: "AchievementDetail",
    components: {Footer, Header, BottomMenu},
    props: {
        achievement: {
            required: true
        },
    },
    mounted() {
        document.querySelector('body').classList.add('bg-white');
    }
}
</script>
