<template>
    <nav
        class="nav top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 "
    >
        <div
            class="container px-4 mx-auto flex flex-wrap items-center justify-between"
        >
            <div
                class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start"
            >
                <a
                    class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white"
                    href="#"
                >IGruzanets </a
                ><button
                class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                type="button"
                v-on:click="toggleNavbar()"
            >
                <i class="text-white fas fa-bars"></i>
            </button>
            </div>
            <div
                class="lg:flex flex-grow justify-between bg-white lg:bg-transparent lg:shadow-none"
                v-bind:class="{'hidden': !showMenu, 'block': showMenu}"
            >
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
                    <li class="flex items-center">
                        <NavItem :isVisible="true" route="/home">Главная</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="true" route="/services">Услуги</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="true" route="/about">О нас</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="true" route="/reviews">Отзывы</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="true" route="/service">Главная</NavItem>
                    </li>
                </ul>
                <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                    <li class="flex items-center">
                        <NavItem :isVisible="!userState" route="/register">Регистрация</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="!userState" route="/login">Вход</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="userState" route="/profile">Профиль</NavItem>
                    </li>
                    <li class="flex items-center">
                        <NavItem :isVisible="userState" @click.prevent="logout" route="/exit">Выход</NavItem>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script setup>
import {useStore} from "vuex";
import {computed, onMounted} from "vue";
import NavItem from '../../NavItem.vue'
import {ref} from "vue";

//uses
const store = useStore();
//
const userState = computed(()=> store.getters["authUser/userState"]);
const logout = ()=>{
    store.dispatch('authUser/logoutUser');
};
const getData = ()=>{
    store.dispatch('authUser/getDataUser');
    console.log(userState);
}
//hooks
onMounted(()=>{
    getData();
});



    const showMenu  = ref(false);
    const toggleNavbar = ()=>{
        showMenu.value = !showMenu.value;
    }
</script>
<style scoped>
.nav{
    background-color: rgba(255, 255,255, 0.1);
}
</style>
