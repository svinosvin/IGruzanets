
<template>
    <div class="page-wrapper min-h-screen g-gradient-light " :class="{'sidebar-active': sidebarSmall}">
        <header class="header">
            <div class="header__wrapper">
                <nav class="header__nav">
                    <div class="header__nav__block">
                        <a href="" class="header__nav__link">dasdasdsa</a>
                    </div>
                    <div class="header__nav__block">
                        <a href="" class="header__nav__link">dasdasdsa</a>
                    </div>
                    <div class="header__nav__block">
                        <a href="" class="header__nav__link">dasdasdsa</a>
                    </div>
                    <div class="header__nav__block">
                        <a href="" class="header__nav__link">dasdasdsa</a>
                    </div>
                    <div class="header__nav__block">
                        <a href="" class="header__nav__link">dasdasdsa</a>
                    </div>
                </nav>
            </div>
        </header>

        <aside class="main-sidebar">
            <div class="sidebar">
                <div class="sidebar__header">
                    <div class="sidebar__logo">
                        <div>
                            <a class="sidebar__logo__link" href="#">IGruzanets</a>
                        </div>
                    </div>
                    <div class="sidebar__burger" @click="switchSidebar">
                        <i class='pi pi-bars icon' ></i>
                    </div>
                </div>
                <!--Links-->
                <nav class="sidebar__nav">
                    <NavLink :isOpen="show" route="/admin/home" tooltip="Главная" icon="pi-home">Главная</NavLink>
                    <NavLink :isOpen="show" route="/admin/services" tooltip="Услуги" icon="pi-user">Услуги</NavLink>
                    <NavLink :isOpen="show" route="/admin/drivers" tooltip="Водитель" icon="pi-user">Водитель</NavLink>
                    <NavLink :isOpen="show" route="/admin/autos" tooltip="Машины" icon=" pi-car">Машины</NavLink>
                    <NavLink :isOpen="show" route="/admin/subresources" tooltip="Ресурсы" icon=" pi-car pi-table">Ресурсы</NavLink>
                </nav>
                <div class="profile__content">
                    <div class="profile">
                        <div class="profile__details">
                            <img src="../../../../images/admin/user.jpg" alt="">
                            <div class="name__job">
                                <div class="name">Artem Ivanets</div>
                                <div class="job">Programmer</div>
                            </div>
                        </div>
                        <div class="log_out_wrapper">
                            <i class="pi pi-sign-out" id="log_out"></i>
                        </div>
                    </div>
                </div>

            </div>
        </aside>
        <main class="main">
            <div class="main__wrapper">
                <div class="container mx-auto">
                    <router-view></router-view>
                </div>
            </div>
        </main>
    </div>
</template>


<script setup>
import Header from "./layout/Header.vue";
import Footer from "./layout/Footer.vue";
import axios from "../../../axios/axios-instance";
import {useStore} from "vuex"
import {computed, onMounted, ref} from "vue";


//uses
const store = useStore();
const currentAdmin = computed(()=>store.state.authAdmin.admin);
//
//refs
let sidebarSmall = ref(false);
let show = ref(false);

//
// Methods
//
const switchSidebar = () =>{
    sidebarSmall.value = !sidebarSmall.value;
    if(show.value===true){
        setTimeout(()=>{
            show.value = !show.value;
        },20)
    }
    else {
        show.value = !show.value;

    }



}

const getData = () =>{
    store.dispatch('authAdmin/getDataAdmin');
};
const logout = ()=> {
    store.dispatch('authAdmin/logoutAdmin');

}
//
onMounted(getData);


</script>



<style scoped lang="scss">

$sidebar_bg: #11101C;
$sidebar_bghover: #FFFFFF;
$sidebar_bgactive:#FFFFFF;

$sidebar_color:#FFFFFF;
$sidebar_colorhover:#35313A;
$sidebar_coloractive:#35313A;
$sidebar_size:225px;
$sidebar_size_close:80px;


*{
    box-sizing: border-box;
    margin: 0;
    text-transform: none;
    text-decoration: none;
    padding: 0;
}

.header {
    margin-left: $sidebar_size;
    width: 100vw;
    background-color: rgb(239, 244, 248);

    &__wrapper{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 auto;
        max-width: 97vw;
    }
    &__nav{
        display: flex;
        flex-wrap: nowrap;
        padding-right: 20rem;
        padding-left: 5rem;;

        &__block{
            padding: 2em;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    }
    position: fixed;
    top: 0;
    z-index: 20;
}

.main{
   padding-left: calc($sidebar_size + 150px);
   padding-top: 150px;
   padding-right: 150px;
}

.sidebar-active .main{
    padding-left: calc($sidebar_size_close + 150px);

}

.main-sidebar{
    transition:all 2ms ease;
    box-shadow: 0 0 60px 0 rgba(15, 15, 15, 0.5), 0 5px 5px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    height: 100%; /* Full-height: remove this if you want "auto" height */
    width: $sidebar_size; /* Set the width of the sidebar */
    position: fixed; /* Fixed Sidebar (stay in place on scroll) */
    z-index: 1; /* Stay on top */
    top: 0; /* Stay at the top */
    left: 0;
    background-color: $sidebar_bg; /* Black */
    overflow-x: hidden; /* Disable horizontal scroll */
    overflow-y: hidden; /* Disable horizontal scroll */

    padding-top: 20px;

}
.sidebar{
    word-wrap: break-word;
    display: flex;
    flex-direction: column;
    width: 100%;
    transition: all 0.5s ease;
    &__header{
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        padding-bottom: 2px;
        border-bottom: 5px solid rgba(251, 251, 251, 0.1);

    }
    &__burger{

        text-align: right;
        width: 100%;
        font-size: 32px;
        padding-bottom: 10px;
        padding-right: 10px;
        color: $sidebar_color;
        & i{
            cursor: pointer;
            margin-right:8px;
            transition: 0.2s all;
        }
        & i:hover{
            color: rgb(132, 140, 138);
        }
    }
    &__logo{
        display: flex;
        align-items: center;
        text-align: left;
        padding: 10px 20px 20px 40px;
        &__link{
            font-size: 22px;
            font-weight: 700;
            display: block;
            max-width: 150px;
            color: $sidebar_color;
            &:hover{
                color: rgb(230, 224, 224);
            }
        }
    }
    &__nav{
        width: 100%;
    }
    & .profile__content{
        color: $sidebar_color;
        position: absolute;
        bottom: 0px;
        left: 0;
        font-size: 25px;
        & i{
            font-size: 30px;
        }
        & img{
            height: 45px;
            width: 45px;
            object-fit: cover;
            border-radius: 12px;
        }
    }

}
.profile__content .profile{
    position: relative;
    width: 100%;
    height: 60px;
    padding: 0 0 20px 20px;
}
.profile__content .profile .profile__details{
    display: flex;
    align-items: center;
}

.profile .profile__details .name__job{
    margin-left: 10px;
}
.profile .profile__details .job{
    font-size: 10px;
}
.profile .profile__details .name{
    font-size: 13px;
    font-weight: 400;
}
.profile #log_out{
    z-index: 12;
    position: absolute;
    margin-left: 30px;

    bottom: 10px;
    transform: translateX(260%);
    min-width: 50px;
    line-height: 50px;
    font-size: 22px;
    border-radius: 12px;
}



.profile__content{
    border-radius: 20px;
    padding-top: 10px;
    width: 100%;
    background-color: #1C1A2E;
}

.sidebar__nav{

    position: relative;
    padding-top: 20px;
}
.nav{
    &__block{
        position: relative;
        font-size: 17px;
        background-color: $sidebar_bg;
        padding: 5px 20px 10px 40px;
        width: 100%;
        display: flex;
        justify-content: center;
        transition: .2s all ;
        align-items: center;

        &:hover{
            background:$sidebar_bghover;
        }


        // &:hover i{

        //     color: $sidebar_colorhover;

        // }
        // &:hover a{
        //   color: $sidebar_colorhover;
        // }

        border-radius: 5px;
    }

}

.nav__link{
    line-height: 50px;
    display: block;
    width: 100%;
    max-width: 250px;
    color: $sidebar_color;
}

.icon{
    padding-right: 30px;
    font-size: 25px;
    width:30px;
    height: 25px;
    color: $sidebar_color;
}
.nav__block:hover .icon{
    color: $sidebar_colorhover;

}

.nav__block:hover .nav__link{
    color: $sidebar_colorhover;
}



.nav__block .tooltip{
    display: none;
    text-align: center;
    position: fixed;
    z-index: 100;
    line-height: 30px;
    transform: translateY(65%) translateX(110%);

    border-radius: 6px;
    background-color: $sidebar_colorhover;
    color: $sidebar_color;
    height: 35px;
    width: 122px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}


.link{
    background-color: aqua;
}



.sidebar-active {

    & .nav__link{
        display: none;
    }
    &  .nav__block{
        padding-left: 20px;
    }
    &  .nav__block:hover .tooltip{
        display: block;
        transform: translateY(65%) translateX(80%);
    }

    & .header {

        margin-left: $sidebar_size_close;
    }
    & .sidebar__logo {

        display: none;
    }
    & .sidebar__burger i{
        margin-right: 15px ;
    }
    & .sidebar__header{
        padding-bottom: 7px;

    }
    & .profile__content .profile .profile__details{
        display: none;
    }
    & .profile #log_out{
        transform: translateX(-45%);
    }
    & .main-sidebar {
        width: $sidebar_size_close;
    }


}
//
//@media screen and (max-width: 1000px) {
//    .main-sidebar {
//        width: $sidebar_size_close;
//    }
//    .nav__link{
//        display: none;
//    }
//    .nav__block{
//        padding-left: 20px;
//    }
//    .nav__block:hover .tooltip{
//        display: block;
//        transform: translateY(65%) translateX(80%);
//
//    }
//    .header {margin-left:
//        $sidebar_size_close;
//    }
//
//    .sidebar__logo {
//        display: none;
//    }
//    .sidebar__burger i{
//        margin-right: 15px ;
//    }
//    .profile__content .profile .profile__details{
//        display: none;
//    }
//    .profile #log_out{
//        transform: translateX(-60%);
//    }
//}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.25);
    }
    100% {
        transform: scale(1);
    }
}

</style>
