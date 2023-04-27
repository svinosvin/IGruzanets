<template>
    <div
        class="relative pt-14 pb-32 flex content-center items-center justify-center"
        style="min-height: 75vh;"
    >
    <h1 class="text-3xl text-white font-bold">
        Services
    </h1>

    </div>
</template>

<script setup>
import {useStore} from "vuex";
import ServiceService from '../../services/ServiceService.js';
const serviceService = new ServiceService();
const store = useStore();


</script>

<style scoped>

</style>
