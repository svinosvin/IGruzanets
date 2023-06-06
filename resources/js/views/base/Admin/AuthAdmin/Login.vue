
<template>
    <div class="wrapper bg-gradient-gray-dark  min-h-screen">
        <div class="container login-pager">
            <Form :validation-schema="schema" class="form"  validate-on-mount @submit="login">

            <div class="w-full flex-col shrink-0 grow-0">
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Email</h2>
                        <InputText placeholder="" name="Email"  сlass="w-full" v-model="admin.email"></InputText>
                        <ValidationComponent name="email" class="w-full" v-model="admin.email"></ValidationComponent>

                    </div>
                    <div class="text-left">
                        <h2 class="text-white font-light mb-2">Пароль</h2>
                        <Password class="w-full" :feedback="false"  toggleMask   v-model="admin.password">
                        </Password>
                        <div>
                            <ValidationComponent name="password" class="w-full" v-model="admin.password"></ValidationComponent>
                        </div>

                    </div>
                    <my-button type="submit" @click.prevent="login">login</my-button>
                    <router-link to="/home"> <p class="message">Вы не администратор? <a href="#">На главную</a></p> </router-link>
                </div>
            </Form>
        </div>
    </div>
</template>

<script setup>
import { Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
import {useStore} from "vuex";
import {ref} from "vue";

//VALIDATION SCHEMA
const schema = yup.object().shape({
    email: yup.string().email("Неправильны формат почты").required(()=>'Еmail - обязательное поле'),
    password: yup.string().required(() => "Пароль - обязательное поле"),

});
//uses
const store = useStore();
const admin = ref({})

const login = ()=>{
    const resp = store.dispatch('authAdmin/loginAdmin', admin.value);
    console.log(resp)
}

</script>

<style lang="scss" scoped>

.login-pager {
    font-weight: bold;
    width: 550px;
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
    max-width: 550px;
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
