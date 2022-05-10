<template>
    <fragment>
        <Header>
            <template v-slot:left>
                <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </template>
            <template v-slot:title>
                {{ item.title }}
            </template>
        </Header>
        <div id="appCapsule" class="full-height">
            <div class="section mt-2">
                <h1>
                    {{ item.title }}
                </h1>
                <div class="blog-header-info mt-2 mb-2">
                    <div>
                        <img :src="'./../assets/sample/'+company.image" alt="img" class="imaged w24 rounded me-05">
                        by {{ company.title }}
                    </div>
                    <div>
                        {{ item.created_at | myDate }}
                    </div>
                </div>
            </div>
            <div class="section mt-2">
                <figure>
                    <img :src="productImage(item.image)" alt="image" class="imaged img-fluid">
                </figure>
                <p>
                    {{ item.description }}
                </p>
            </div>
            <div class="section">
                <h2 style="text-align: center;" class="price">$ {{item.price}}</h2>
                <a href="#" class="btn btn-primary btn-block btn-sm" @click="buy">{{ $trans('strings.Buy') }}</a>
            </div>
            <div class="section mt-3">
                <h2>{{$trans('strings.Comments')}}</h2>
                <div class="row mt-3 mb-2">
                    <Comments :id="item.id"></Comments>
                    <NewComment :id="item.id"></NewComment>
                </div>
            </div>
        </div>
        <BottomMenu></BottomMenu>
    </fragment>
</template>

<script>
import BottomMenu from "../LayoutComponents/BottomMenu";
import Header from "../LayoutComponents/Header";
import Comments from "./Comments";
import NewComment from "./NewComment";
export default {
    name: "ProductDetail",
    components: {BottomMenu, Header, Comments, NewComment},
    props: {
        item: {
            type: Object,
            required: true
        },
        company: {
            type: Object,
            required: true
        }
    },
    methods:{
        productImage(image) {
            if (image.toString().startsWith('products/')) {
                return './../assets/sample/' + image
            }
            return image
        },
        buy(){
            axios.post('/buy/product', {
                id: this.item.id
            }).then((res)=>{
                if(res.data.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: this.$trans('strings.The operation was successful!'),
                        text: this.$trans('strings.The purchase of goods was successfully completed'),
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: this.$trans('strings.The operation cannot be performed'),
                        text: this.$trans('strings.Insufficient funds for the purchase of goods'),
                    });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
