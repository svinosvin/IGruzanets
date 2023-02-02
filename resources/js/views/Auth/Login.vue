<template>
    <div class="wrapper bg-gradient-gray-dark  min-h-screen">

        <div class="login-pager">
            <form class="form">
                <my-input type="text" placeholder="email" v-model="user.email"></my-input>
                <my-input type="text" placeholder="password" v-model="user.password"></my-input>
                <my-button type="submit" @click.prevent="login">login</my-button>
                <router-link to="/register"> <p class="message">Вы не зарегистрированы? <a href="#">Регистрация</a></p> </router-link>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",

    data:()=>({
        user:{
            email:"",
            password:"",
        }
    }),
    methods:{
        login(){
            this.$store.dispatch('authUser/loginUser', this.user);
        }
    }

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

