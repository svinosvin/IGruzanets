<template>
    <div class=" text-center pt-80">
        <span class="text-7xl font-extralight"> <span class="text-red-800">404</span> -  Page was not found</span>
        <br>
        <br>
        <span>Redirecting back in {{time}} sec</span>
    </div>

</template>

<script setup>
import {onMounted, onUnmounted, ref} from "vue";
import router from "../router";

const time = ref(3);
let interval;
//methods
const countdown = () =>{
   interval = setInterval(function (){
        if(time.value==0){
            clearInterval(interval);
            router.back();
        }
        if(time.value>0)
            time.value-=1;

    }, 1000)


}

onMounted(countdown)
onUnmounted(function (){
    clearInterval(interval)
})
</script>

<style scoped>




</style>
