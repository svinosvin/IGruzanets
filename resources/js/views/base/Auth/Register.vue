<template>

        <div class=" login-pager">
            <Form :validation-schema="schema" class="form"  validate-on-mount @submit="login">

                <div class="w-full flex-col shrink-0 grow-0">
                    <div class="flex flex-wrap">
                        <div class="text-left mr-2">
                            <h2 class="text-white font-light mb-2">Имя</h2>
                            <InputText placeholder="" name="Name"  сlass="w-full" v-model="user.name"></InputText>
                            <ValidationComponent name="name" v-model="user.name"></ValidationComponent>

                        </div>
                        <div class="text-left ">
                            <h2 class="text-white font-light mb-2">Фамилия</h2>
                            <InputText placeholder="" name="Firstname"  сlass="w-full" v-model="user.first_name"></InputText>
                            <ValidationComponent name="first_name" v-model="user.first_name"></ValidationComponent>

                        </div>

                    </div>
                    <div class="text-left ">
                        <h2 class="text-white font-light mb-2">Отчество</h2>
                        <InputText placeholder="" name="Email"  сlass="w-full" v-model="user.patronymic"></InputText>
                        <ValidationComponent name="patronymic" v-model="user.patronymic"></ValidationComponent>

                    </div>
                    <div class="text-left ">

                        <h2 class="text-white font-light mb-2">Email</h2>
                        <InputText placeholder="" name="Email"  сlass="w-full" v-model="user.email"></InputText>
                        <ValidationComponent name="email" v-model="user.email"></ValidationComponent>

                    </div>
                    <div class="text-left ">

                        <h2 class="text-white font-light mb-2">Телефон</h2>
                        <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="user.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                        <ValidationComponent name="tel_number" v-model="user.tel_number"></ValidationComponent>

                    </div>
                    <div class="text-left ">

                        <h2 class="text-white font-light mb-2">Пароль</h2>
                        <Password class="w-full"  toggleMask :feedback="false"  v-model="user.password">

                        </Password>
                        <ValidationComponent name="password" v-model="user.password"></ValidationComponent>

                    </div>
                    <div class="text-left ">

                        <h2 class="text-white font-light mb-2">Повторите пароль</h2>
                        <Password class="w-full" :feedback="false"  toggleMask   v-model="user.password_confirmation">
                        </Password>
                        <ValidationComponent name="password_confirmation" v-model="user.password_confirmation"></ValidationComponent>

                    </div>
                    <my-button type="submit" @click.prevent="register">Register</my-button>
                    <router-link to="/login"> <p class="message">Вы не зарегистрированы? <a href="#">Логин</a></p> </router-link>
                    <router-link to="/home"> <p class="message">На главную? <a href="#">На главную</a></p> </router-link>

                </div>
            </Form>
    </div>

</template>

<script setup>
import {useStore} from "vuex";
import {ref} from "vue";
//uses


import { Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';
;

//VALIDATION SCHEMA
const schema = yup.object().shape({
    name: yup.string().required(()=>'Имя - обязательное поле'),
    first_name: yup.string().required(()=>'Фамилия - обязательное поле'),
    patronymic:  yup.string().required(()=>'Отчество - обязательное поле'),
    tel_number: yup.string().required(() => "Номер телефона - обязательное поле"),
    email: yup.string().email("Неправильны формат почты").required(()=>'Еmail - обязательное поле'),
    password: yup.string().required(() => "Пароль - обязательное поле").min(8,'Минимально 8 символов'),
    password_confirmation: yup.string()
        .oneOf([yup.ref('password'), null], 'Пароли должны совпадать').required("Подтверждение пароля - обязательное поле"),

});
const store = useStore();
const user = ref({})

const register = ()=>{
    store.dispatch('authUser/registerUser', user.value);
}

</script>


<style lang="scss">


.login-pager {

    font-weight: bold;
    padding: 10px 0 0;
    margin: auto;
    display:flex;
}
.block{
    padding: 0 40px 0 40px;
}
.form {
    position: relative;
    z-index: 1;
    background-color: var(--color-grey-dark-1);
    background-size: cover;
    background-position: center;
    margin: 0 auto ;
    padding: 8px 50px;
    text-align: center;
    box-shadow: 0 0 60px 0 rgba(0, 0, 0, 0.5), 0 5px 5px rgba(0, 0, 0, 0.2);
}
.form input {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 10px;
    box-sizing: border-box;
    font-size: 14px;
}
.form .message {

    color: #b3b3b3;
    font-size: 12px;
}
.form .message a {
    text-decoration: none;
    color: var(--color-grey-light-4);
}
</style>
