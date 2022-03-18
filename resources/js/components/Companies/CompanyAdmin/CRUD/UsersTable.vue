<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Your customers')}}
            </template>
        </Header>
        <br/>
        <br/>
        <div class="section mt-2 mb-2">
            <div class="section-title">
               {{$trans('strings.Your company\'s customers')}}
            </div>
            <h4 class="text-center" v-if="users.length===0">{{$trans('strings.Your company doesn\'t have a single client yet')}}</h4>
            <div v-if="users.length>0" class="card text-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{$trans('strings.Action Name')}}</th>
                            <th>{{$trans('strings.Avatar')}}</th>
                            <th>{{$trans('strings.Phone number')}}</th>
                            <th>{{$trans('strings.Country')}}</th>
                            <th>{{$trans('strings.Region')}}</th>
                            <th>{{$trans('strings.Address')}}</th>
                            <th>{{$trans('strings.Social network')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in paginatedData" :key="user.id">
                            <td v-if="user.name!==null">{{ user.name }}</td>
                            <td v-if="user.name===null">{{$trans('strings.No data available')}}</td>
                            <td><img :src="'assets/sample/' +user.avatar" alt="image"
                                     class="imaged w100 rounded"></td>
                            <td v-if="user.phone!==null">{{ user.phone }}</td>
                            <td v-if="user.phone===null">{{$trans('strings.No data available')}}</td>
                            <td v-if="user.country!==null">{{ user.country }}</td>
                            <td v-if="user.country===null">{{$trans('strings.No data available')}}</td>
                            <td v-if="user.region!==null">{{ user.region}}</td>
                            <td v-if="user.region===null">{{$trans('strings.No data available')}}</td>
                            <td v-if="user.address!==null">{{ user.address}}</td>
                            <td v-if="user.address===null">{{$trans('strings.No data available')}}</td>
                            <td v-if="user.messengers!==null">
                                <ul class="listview image-listview no-line no-space flush"
                                    style="background: none!important">
                                    <li v-for="(social, key) in user.messengers">
                                        <div class="item" v-if="social!==null">
                                            <div class="icon-box bg-primary">
                                                <i :class="'fab fa-'+key"></i>
                                            </div>
                                            <div class="in">
                                                <div class="input-wrapper w-100">
                                                    <a :href="social" target="_blank"><label>{{key}}</label></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                            <td v-if="user.messengers===null">{{$trans('strings.No data available')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <nav>
                <ul class="pagination pagination-rounded">
                    <li>
                        <button class="page-link" @click="prevPage" :disabled="pageNumber===0" type="button">
                            {{$trans('strings.Previous')}}
                        </button>
                    </li>
                    <li class="disabled ">
                        <a class="page-link" style="background: #fff !important;color: #6236FF !important;">
                            {{$trans('strings.Page')}} {{ pageNumber + 1 }} {{$trans('strings.from')}} {{ pageCount }}
                        </a>
                    </li>
                    <li>
                        <button class="page-link" @click="nextPage" :disabled="pageNumber >= pageCount-1" type="button">
                            {{$trans('strings.Next')}}
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

    </fragment>
</template>

<script>
import Header from "../../../LayoutComponents/Header";


export default {
    name: "UsersTable",
    components: {Header},
    props: {
        users: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            pageNumber: 0,
            size: 10
        }
    },
    methods: {
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        },
    },
    computed: {
        pageCount() {
            let l = this.users.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;
            return this.users.slice(start, end);
        }
    },
}
</script>

<style scoped>
.pagination {
    justify-content: center;
}

.page-link {
    background: #6236FF !important;
    color: #fff !important;
}

@media (max-width: 375px) {
    .page-link {
        font-size: 70%;
    }
}
</style>
