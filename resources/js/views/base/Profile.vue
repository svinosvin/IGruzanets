<template>
    <div class="container-md">
        <img src="" class="pi pi-user" alt="">
        <div>
            <input type="text" name="email" v-model="user.email">
            <input type="text" name="name" v-model="user.name">
            <input type="text" name="first_name" v-model="user.first_name">

        </div>
        {{user}}
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import {computed, onMounted} from "vue";

//uses
const store = useStore();
const user = computed(()=> store.getters["authUser/currentUser"])


const getData = ()=>{
    store.dispatch('authUser/getDataUser');
    console.log(user)
}
onMounted(()=>{
    getData();

})

</script>

<style scoped>

</style>
