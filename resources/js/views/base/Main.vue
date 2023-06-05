<template>
    <div class="min-h-screen bg-black">
        <div class="wrapper">
            <header class="header min-w-full bg-neutral-700">
              <NavBar></NavBar>
            </header>
            <main>
                    <div class="content ">
                        <router-view></router-view>
                    </div>
            </main>
        <footer class="relative bg-gray-300 pt-8 pb-6">
            <div
                class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;"
            >
                <svg
                    class="absolute bottom-0 overflow-hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                    version="1.1"
                    viewBox="0 0 2560 100"
                    x="0"
                    y="0"
                >
                    <polygon
                        class="text-gray-300 fill-current"
                        points="2560 0 2560 100 0 100"
                    ></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4">
                        <h4 class="text-3xl font-semibold">Будем на связи</h4>
                        <h5 class="text-lg mt-0 mb-2 text-gray-700">
                            График работы: 9:00 - 20:00 - ежедневно
                        </h5>
                        <div class="mt-6">
                            <button
                                class="bg-white text-blue-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                                type="button"
                            >
                                <i class="flex fab fa-twitter"></i></button
                            ><button
                            class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                            type="button"
                        >
                            <i class="flex fab fa-facebook-square"></i></button
                        ><button
                            class="bg-white text-pink-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                            type="button"
                        >
                            <i class="flex fab fa-dribbble"></i></button
                        ><button
                            class="bg-white text-gray-900 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3"
                            type="button"
                        >
                            <i class="flex fab fa-github"></i>
                        </button>
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="flex flex-wrap items-top mb-6">
                            <div class="w-full lg:w-4/12 px-4 ml-auto">
              <span
                  class="block uppercase text-gray-600 text-sm font-semibold mb-2"
              >Полезные ссылки</span
              >
                                <ul class="list-unstyled">
                                    <li>
                                        <a
                                            class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                                            href="#"
                                        >О нас</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                                            href="#"
                                        >Github</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div class="w-full lg:w-4/12 px-4">
              <span
                  class="block uppercase text-gray-600 text-sm font-semibold mb-2"
              >Другие ресурсы</span
              >
                                <ul class="list-unstyled">

                                    <li>
                                        <a
                                            class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                                            href="#"
                                        >Соглашения</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                                            href="#"
                                        >Приватность</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm"
                                            href="#"
                                        >Связаться с нами</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-6 border-gray-400" />
                <div
                    class="flex flex-wrap items-center md:justify-between justify-center"
                >
                    <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                        <div class="text-sm text-gray-600 font-semibold py-1">
                            Copyright © {{new Date().getFullYear()}} Company
                            <a
                                href="https://www.creative-tim.com"
                                class="text-gray-600 hover:text-gray-900"
                            >IGruzanets</a
                            >.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>

</template>

<script setup>

import {useStore} from "vuex";
import {computed, onMounted} from "vue";
//uses
const store = useStore();
//
import NavBar from '../../components/ui/user/navbar/Navbar.vue';

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




</script>

<style lang="scss" scoped>

.footer{
    background-color:var(--color-blue-dark-1);
    color: white;
}
.header{
    position: fixed;
    z-index: 1;
    background-color:var(--color-blue-dark-1);
}
.content{
    margin: 0 auto;

}
.wrapper{
    background-color: rgba(150,0,250, 0.1);
}
</style>
