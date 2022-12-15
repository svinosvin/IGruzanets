<template>
    <header>
        <div class="pt-10">
            <div class="flex space-x-8 ">
                <div>
                    <router-link to="/home">Главная</router-link>
                </div>
                <div>
                    <router-link to="/services">Услуги</router-link>
                </div>
                <div>
                    <router-link to="/reviews">Отзывы</router-link>
                </div>
                <div>
                    <router-link to="/about">О нас</router-link>
                </div>
                <div>
                    <router-link to="/register">Регистрация</router-link>
                </div>
                <div>
                    <router-link to="/login">Вход</router-link>
                </div>
                <div>
                    <router-link to="/about">Профиль</router-link>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="content">
            <router-view></router-view>
        </div>
    </main>
    <footer>

    </footer>
</template>

<script>
export default {
    name: "Main"
}
</script>

<style scoped>

</style>
