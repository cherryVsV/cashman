<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 v-if="!showFriends" class="title">{{ $trans('strings.Users') }}</h2>
            <h2 v-if="showFriends" class="title">{{ $trans('strings.Company Friends') }}</h2>
            <a v-if="showFriends" href="friends" class="link">{{ $trans('strings.View all') }}</a>
        </div>
        <!-- carousel small -->
        <splide :slides="users" :options="options">
            <splide-slide v-for="user in users" :key="user.id">
                <UserItem :user=user></UserItem>
            </splide-slide>
        </splide>
        <!-- * carousel small -->
    </div>
</template>

<script>
import UserItem from "./UserItem";
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "UserList",
    components: {UserItem, Splide, SplideSlide},
    data: function () {
        return {
            options: {
                perPage: 10,
                rewind: true,
                gap: 16,
                padding: 16,
                arrows: false,
                pagination: false,
                cover: true,
                lazyLoad: 'sequential',
                breakpoints: {
                    320: {
                        perPage: 2,
                    },
                    375: {
                        perPage: 2,
                    },
                    425: {
                        perPage: 2,
                    },
                    600: {
                        perPage: 2,
                    },
                    768: {
                        perPage: 3,
                    },
                    1024: {
                        perPage: 4,
                    },
                    1440: {
                        perPage: 5,
                    },
                    1600: {
                        perPage: 6,
                    },
                    1680: {
                        perPage: 6,
                    },
                    1920: {
                        perPage: 8,
                    },
                    2500: {
                        perPage: 10,
                    },
                }
            },
        }
    },
    props: {
        showFriends: {
            required: true,
            type: Boolean
        },
        users: {
            required: true
        }
    }
}
</script>
