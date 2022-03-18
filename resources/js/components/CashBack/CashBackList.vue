<template>
    <div class="section mt-4">
        <div class="section-heading padding">
            <h2 class="title">{{$trans('strings.Accrual/write-off history')}}</h2>
        </div>
        <!-- carousel single -->
        <div class="carousel-single splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide" v-for="cashback in cashbacks">
                        <CashBackItem :cashback=cashback></CashBackItem>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import CashBackItem from "./CashBackItem";

export default {
    name: "CashBackList",
    components: {CashBackItem},

    props: {
        cashbacks: {
            required: true
        }
    }
}
</script>
