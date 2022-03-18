<template>
    <div class="blok">
        <ul class="topmenu">
            <!--Русский-->
            <li v-if="lang==='ru'" ><a href="#"><img src="assets/ru.png" alt="" width="89" height="34" /></a>
                <ul class="submenu">
                    <!--Английский-->
                    <li><a href="#"><img src="assets/en.png" alt="" width="89" height="34" @click="setLocale('en')"/></a></li>

                </ul>
            </li>
            <!--Английский-->
            <li v-if="lang==='en'"><a href="#"><img src="assets/en.png" alt="" width="89" height="34" /></a>
                <ul class="submenu">
                    <!--Русский-->
                    <li><a href="#"><img src="assets/ru.png" alt="" width="89" height="34" @click="setLocale('ru')"/></a></li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "LangSwitcher",
    methods:{
        setLocale(lang){
            axios.get('/locale/'+lang).then(()=>{
                window.location.reload()
            })
        }
    },
    mounted(){
        this.lang = localStorage.getItem('locale')
    },
    data(){
        return{
            lang: null
        }
    }
}
</script>

<style scoped>
.blok {
    text-align: center;
    width:89px;
}
.blok a {
    text-decoration: none;
    display: block;
    transition: .5s linear;

}
.blok ul {
    list-style: none;
    margin: 0;
    padding: 0;

}
.topmenu > li {
    display: block;
    position: relative;
    top:0;
    left:0;
    margin-bottom: 2px;
}
.submenu {
    position: absolute;
    left: 0;
    top:0;
    z-index: 5;
    width:89px;
    visibility: hidden;
    opacity: 0;
    transform: translateY(10px);
    transition: .5s ease-in-out;
}
.submenu li {
    position: relative;
    top:0;
    left:0;
}
.submenu .submenu {
    position: absolute;
    top: 0;
    left: calc(100% - 1px);
    left: -webkit-calc(100% - 1px);
}
.blok li:hover > .submenu {
    visibility: visible;
    opacity: 1;
    transform: translateY(0px);
}
</style>
