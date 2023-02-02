<template>
    <div class="min-h-screen  g-gradient-light">
            <header class="header min-w-full bg-neutral-700">
                <div class="container mx-auto">
                    <div class="pt-2 pb-10">
                        <nav class="flex text-white">
                            <NavItem :isVisible="true" route="/home">Главная</NavItem>
                            <NavItem :isVisible="true" route="/services">Услуги</NavItem>
                            <NavItem :isVisible="true" route="/reviews">Отзывы</NavItem>
                            <NavItem :isVisible="true" route="/about">О нас</NavItem>
                            <NavItem :isVisible="!userState" route="/register">Регистрация</NavItem>
                            <NavItem :isVisible="!userState" route="/login">Вход</NavItem>
                            <NavItem :isVisible="userState" route="/profile">Профиль</NavItem>
                            <NavItem :isVisible="userState" @click.prevent="logout" route="/exit">Выход</NavItem>
                        </nav>
                    </div>
                </div>
            </header>

            <main>
                <div class="container mx-auto">
                    <div class="content">
                        <router-view></router-view>
                    </div>
                </div>
            </main>
            <footer class="footer  position-absolute bottom-0 left-0 min-w-full">
                <div class="container mx-auto">
               <div>
                   dsadasdasdas
               </div>
                <div>
                    dsadasdasdas
                </div>
                <div>
                    dsadasdasdas
                </div>
                <div>
                    dsadasdasdas
                </div>
                <div>
                    dsadasdasdas
                </div>
                <div>
                    dsadasdasdas
                </div>
                </div>
            </footer>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import {computed, onMounted} from "vue";
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
    padding-top: 7rem;

}

</style>
