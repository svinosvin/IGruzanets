
<template>
        <div class="wrapper">
            <Header/>
            <div class="content-wrapper">
                <div class="container mx-auto">
                    <router-view></router-view>
                </div>
            </div>
            <Footer/>
        </div>
</template>


<script>
import Header from "./layout/Header.vue";
import Footer from "./layout/Footer.vue";
import axios from "../../axios/axios-instance";

// import Main from "./Pages/AdminHome.vue";
// import Sidebar from "./Elements/Sidebar.vue";
export default {
    name:'AdminMain',
    components: {
        Footer,
        Header
    },
    mounted() {
        this.getData();
    },
    methods:{
        getData(){
            axios.get('/api/admin/get')
             .then(response =>{
                 console.log(response.data);
             })
        },
        logout(){
            this.$store.dispatch('logoutAdmin');
        }

    },

}
</script>



<style scoped lang="scss">

//$bp-largest: 75em;     // 1200px
//$bp-large: 68.75em;    // 1100px
//$bp-medium: 56.25em;   // 900px
//$bp-small: 37.5em;     // 600px
//$bp-smallest: 31.25em; // 500px
//
//.main-part {
//    background-color:  var(--color-grey-dark-2);
//    height: 73rem;
//    flex: 1;
//}
//.container {
//    max-width: 160rem;
//   // margin: 8rem auto;
//    background-color: var(--color-grey-light-2);
//    box-shadow: var(--shadow-dark);
//    min-height: 50rem;
//}
//.header {
//    color: white;
//    height: 6rem;
//    background-color: var( --color-primary-dark);
//    border-bottom: var(--color-grey-light-2);
//    display: flex;
//    justify-content: space-between;
//    align-items: center;
//}
//.content {
//    display: flex;
//}
//.logo-container {
//    margin-left: 2rem;
//    display: flex;
//    align-items: center;
//    &__img{
//        height: 3.25rem;
//        margin-left: 2rem;
//
//    }
//    &__name{
//        margin-left: 20px;
//    }
//
//
//}
//.user-nav {
//    align-self: stretch;
//    display: flex;
//    align-items: center;
//    & > * {
//        padding: 0 2rem;
//        cursor: pointer;
//        height: 100%;
//        display: flex;
//        align-items: center;
//    }
//    &__user{
//        color: white;
//        display: flex;
//        justify-content: space-between;
//    }
//
//    &__user-photo {
//        height: 3.75rem;
//        border-radius: 50%;
//        margin-left: 3rem;
//        padding: 0 2rem;
//    }
//    &__user-name{
//        padding: 0px 20px;
//        margin-left: 20px;
//    }
//
//
//}

//html {
//    box-sizing: border-box;
//    font-size: 62.5%; // 1rem = 10px, 10px/16px = 62.5%
//
//    @media only screen and (max-width: var $bp-large) {
//        font-size: 50%;
//    }
//}
//
//body {
//    font-family: 'Open Sans', sans-serif;
//    font-weight: 400;
//    line-height: 1.6;
//    color: var(--color-grey-dark-2);
//    background-image: linear-gradient(to right bottom, var(--color-primary-light), var(--color-primary-dark));
//    background-size: cover;
//    background-repeat: no-repeat;
//
//    min-height: 100vh;
//}
</style>
