<template>
    <div class="min-h-screen bg-gradient-light">
            <header class="header min-w-full bg-neutral-700">
                <div class="container mx-auto">
                    <div class="pt-10 pb-10">
                        <div class="flex space-x-8 text-white text-bold ">
                            <div>
                                <router-link class="link" to="/home">Главная</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/services">Услуги</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/reviews">Отзывы</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/about">О нас</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/register">Регистрация</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/login">Вход</router-link>
                            </div>
                            <div>
                                <router-link class="link" to="/about">Профиль</router-link>
                            </div>
                        </div>
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
            <footer>

            </footer>
    </div>
</template>

<script>
export default {
    name: "Main"
}
</script>

<style lang="scss" scoped>

.header{
    position: fixed;
    z-index: 1;
}
.content{
    padding-top: 7rem;
}

</style>
