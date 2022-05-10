<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Your achievements')}}
            </template>
        </Header>
        <br/>
        <br/>
        <div class="section mt-2 mb-2">
            <div class="section-title">
                {{$trans('strings.Add a new achievement')}}
                <button @click="newModal" type="button" class="btn btn-icon btn-info me-1">
                    <ion-icon name="add-outline"></ion-icon>
                </button>
            </div>
            <h4 class="text-center" v-if="achievements.length===0">{{$trans('strings.You haven\'t added any of your company\'s achievements yet.')}}</h4>
            <div v-if="achievements.length>0" class="card text-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{$trans('strings.Code')}}</th>
                            <th>{{$trans('strings.Title')}}</th>
                            <th>{{$trans('strings.Images')}}</th>
                            <th>{{$trans('strings.Description')}}</th>
                            <th>{{$trans('strings.Product')}}</th>
                            <th>{{$trans('strings.Amount')}}</th>
                            <th>{{$trans('strings.Prize description')}}</th>
                            <th>{{$trans('strings.Prize image')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="achievement in paginatedData" :key="achievement.id">
                            <td>{{ achievement.id }}</td>
                            <td>{{ achievement.title }}</td>
                            <td>
                                <img :src="'/assets/sample/'+achievement.achievement_image_url" alt="image"
                                     class="imaged w100">
                            </td>
                            <td>{{ achievement.achievement_description }}</td>
                            <td>{{ achievement.value}}</td>
                            <td>{{ achievement.position }}</td>
                            <td>{{ achievement.prize_description}}</td>
                            <td>
                                <img :src="'/assets/sample/'+achievement.prize_image_url" alt="image"
                                     class="imaged w100">
                            </td>
                            <td>
                                <a href="#" @click="editModal(achievement)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd"
                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>
                                /
                                <a href="#" @click="deleteRecord(achievement.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                            </td>

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

        <!-- Modal -->
        <AchievementsModal :form="this.form" :editmode="this.editmode" :id="this.id"></AchievementsModal>

    </fragment>

</template>

<script>
import Header from "../../../LayoutComponents/Header";
import Form from 'vform';
import BottomMenu from "../../../LayoutComponents/BottomMenu";
import AchievementsModal from "../../../Modals/CRUDModals/AchievementsModal";
export default {
    name: "AchievementsTable",
    components: {AchievementsModal, BottomMenu, Header},
    props: {
        id: {
            required: true
        }
    },
    data: function () {
        return {
            achievements: [],
            editmode: false,
            form: new Form({
                id: '',
                title: '',
                achievement_image_url: '',
                achievement_description: '',
                value: '',
                position: '',
                prize_description: '',
                prize_image_url: ''
            }),
            pageNumber: 0,
            size: 10,
            company: []
        }
    },
    methods: {
        editModal(record) {
            this.editmode = true;
            this.form.reset();
            $('#AddNew').modal('show');
            this.form.fill(record);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#AddNew').modal('show');
        },
        deleteRecord(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: this.$trans('strings.Are you sure?'),
                text: this.$trans('strings.It will be impossible to cancel the action'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.$trans('strings.Yes'),
                cancelButtonText: this.$trans('strings.Cancel'),
                reverseButtons: true
            }).then((result) => {
                //send request to the server
                if (result.isConfirmed) {
                    this.form.delete('api/admin/achievements/' + id).then(() => {

                        swalWithBootstrapButtons.fire(
                            this.$trans('strings.Deleted'),
                            this.$trans('strings.The selected entry has been deleted'),
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        this.$trans('strings.Cancelled'),
                        this.$trans('strings.The deletion was canceled'),
                        'error'
                    )
                }

            }).catch(() => {
                swal(this.$trans('strings.Error'), this.$trans('strings.Something went wrong'), "warning")
            });
        },
        loadRecords() {
            axios.get('api/admin/get/achievements/' + this.id).then((response) =>
                {
                    this.achievements = response.data.achievements
                    this.company = response.data.company
                }
            );
        },
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        }

    },

    mounted() {
        this.loadRecords();
        Fire.$on('AfterCreate', () => {
            this.loadRecords();
        });

    },
    computed: {
        pageCount() {
            let l = this.achievements.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;
            return this.achievements.slice(start, end);
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
