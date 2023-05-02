<template>
    <div class="wrapper bg-gradient-gray-dark  min-h-screen">
        <div class="container login-pager">
            <form class="form">
                <div class="w-full flex-col shrink-0 grow-0">
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Email</h2>
                        <InputText placeholder="" name="Email"  сlass="w-full" v-model="user.email"></InputText>
                    </div>
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Телефон</h2>
                        <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="user.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                    </div>
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Пароль</h2>
                        <Password class="w-full" :feedback="true"  toggleMask   v-model="user.password">
                            <!--                        <template #header>-->
                            <!--                            <h6>Pick a password</h6>-->
                            <!--                        </template>-->
                            <!--                        <template #footer>-->
                            <!--                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">-->
                            <!--                                <li>Минимум 8 символов</li>-->
                            <!--                            </ul>-->
                            <!--                        </template>-->
                        </Password>
                    </div>
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Повторите пароль</h2>
                        <Password class="w-full" :feedback="false"  toggleMask   v-model="user.password_confirmation">
                            <!--                        <template #header>-->
                            <!--                            <h6>Pick a password</h6>-->
                            <!--                        </template>-->
                            <!--                        <template #footer>-->
                            <!--                            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">-->
                            <!--                                <li>Минимум 8 символов</li>-->
                            <!--                            </ul>-->
                            <!--                        </template>-->
                        </Password>
                    </div>
                    <my-button type="submit" @click.prevent="register">Register</my-button>
                    <router-link to="/login"> <p class="message">Вы не зарегистрированы? <a href="#">Логин</a></p> </router-link>
                </div>

            </form>
        </div>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import {ref} from "vue";
//uses
const store = useStore();
const user = ref({})

const register = ()=>{
    store.dispatch('authUser/registerUser', user.value);
}

</script>


<style lang="scss">

.login-pager {
    font-weight: bold;
    width: 450px;
    padding: 10% 0 0;
    margin: auto;
    display:flex;
}
.form {
    position: relative;
    z-index: 1;
    background-color: var(--color-grey-dark-1);
    background-size: cover;
    background-position: center;
    max-width: 450px;
    margin: 0 auto 100px;
    padding: 65px;
    text-align: center;
    box-shadow: 0 0 60px 0 rgba(0, 0, 0, 0.5), 0 5px 5px rgba(0, 0, 0, 0.2);
}
.form input {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    box-sizing: border-box;
    font-size: 14px;
}
.form .message {
    margin: 15px;
    color: #b3b3b3;
    font-size: 12px;
}
.form .message a {
    text-decoration: none;
    color: var(--color-grey-light-4);
}
</style>
