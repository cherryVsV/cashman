<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{$trans('strings.Your products')}}
            </template>
        </Header>
        <br/>
        <br/>
        <div class="section mt-2 mb-2">
            <div class="section-title">
               {{$trans('strings.Add a new product')}}
                <button @click="newModal" type="button" class="btn btn-icon btn-info me-1">
                    <ion-icon name="add-outline"></ion-icon>
                </button>
                <button v-if="company.vk_upload" @click="uploadProducts" type="button" class="btn btn-icon btn-warning me-1">
                    <ion-icon name="download-outline"></ion-icon>
                </button>
            </div>
            <h4 class="text-center" v-if="products.length===0">{{$trans('strings.You haven\'t added any of your company\'s products yet.\n Click the \"Upload products from VK\" button or add the product manually.')}}</h4>
            <div v-if="products.length>0" class="card text-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{$trans('strings.Code')}}</th>
                            <th>{{$trans('strings.Title')}}</th>
                            <th>{{$trans('strings.Images')}}</th>
                            <th>{{$trans('strings.Description')}}</th>
                            <th>{{$trans('strings.Price')}}</th>
                            <th>{{$trans('strings.Discount price')}}</th>
                            <th>{{$trans('strings.Type of promotion')}}</th>
                            <th>{{$trans('strings.Action')}}</th>
                            <th>{{$trans('strings.Promo code')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in paginatedData" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.title }}</td>
                            <td>
                                <img :src="productImage(product.image)" alt="image"
                                     class="imaged w100">
                            </td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.discount_price }}</td>
                            <td>{{ product.type }}</td>
                            <td>
                                <a href="#" @click="editModal(product)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd"
                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>
                                /
                                <a href="#" @click="deleteRecord(product.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="/add-promocode">
                                    <button type="button" class="btn btn-icon btn-success me-1">
                                        <ion-icon name="pricetag-outline"></ion-icon>
                                    </button>
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
        <ProductsModal :form="this.form" :editmode="this.editmode" :id="this.id"></ProductsModal>

    </fragment>

</template>

<script>
import Header from "../../../LayoutComponents/Header";
import Form from 'vform';
import BottomMenu from "../../../LayoutComponents/BottomMenu";
import ProductsModal from "../../../Modals/CRUDModals/ProductsModal";

export default {
    name: "ProductsTable",
    components: {ProductsModal, BottomMenu, Header},
    props: {
        id: {
            required: true
        }
    },
    data: function () {
        return {
            products: [],
            editmode: false,
            form: new Form({
                id: '',
                title: '',
                image: '',
                description: '',
                price: '',
                discount_price: '',
                type: ''
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
        uploadProducts() {
            axios.get('/token-company-' + this.id).then(function (response) {
                if (response.data.href !== undefined) {
                    location.href = response.data.href
                }

            })
                .catch(function (error) {
                    console.log(error)
                })
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
                    this.form.delete('api/admin/products/' + id).then(() => {

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
            axios.get('api/admin/get/products/' + this.id).then((response) =>
                {
                    this.products = response.data.products
                    this.company = response.data.company
                }
            );
        },
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        },
        productImage(image) {
            if (image.toString().startsWith('products/')) {
                return './../assets/sample/' + image
            }
            return image
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
            let l = this.products.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;
            return this.products.slice(start, end);
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
