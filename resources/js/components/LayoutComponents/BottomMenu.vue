<template>
    <div class="appBottomMenu">
        <a href="/" class="item">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>{{$trans('strings.Main')}}</strong>
            </div>
        </a>
        <a href="/products" class="item">
            <div class="col">
                <ion-icon name="cash-outline"></ion-icon>
                <strong>{{$trans('strings.Stocks')}}</strong>
            </div>
        </a>
        <a href="#" class="item default">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
            </div>
        </a>
        <a href="/search-company" class="item">
            <div class="col">
                <ion-icon name="grid-outline"></ion-icon>
                <strong>{{$trans('strings.Companies')}}</strong>
            </div>
        </a>
        <a href="/news" class="item">
            <div class="col">
                <ion-icon name="newspaper-outline"></ion-icon>
                <strong>{{$trans('strings.News')}}</strong>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "BottomMenu",
    mounted() {
        const path = window.location.href;
        console.log(path);
        let tmp = false;
        $('.appBottomMenu a').each(function () {
            if (this.href === path) {
                $(this).addClass('active');
                tmp = true;
            }
        });
        if (tmp === false) {
            $('.appBottomMenu .default').addClass('active');
        }
    }
}
</script>
