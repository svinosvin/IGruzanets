<template>
    <div
        class="relative pt-14 pb-32 w-full flex justify-center page-wrapper"
        style="min-height: 75vh;"
    >
        <div class="flex  ">

            <div class="container__wrapper w-full ">
                <div class="card-container flex text-white"  v-for="service in services">
                    <Card class="card_wrapper w-full cursor-pointer" @click="click(service.id)"  >
                        <template #header>
                            <div class="w-full flex align-items-center ">
                                <div class="mb-6 w-full flex justify-center" v-if="service.img!=null">
                                    <img :src="`${service.img}`" alt="Картинка" class="custom-img h-64  " />
                                </div>
                                <div v-else class="w-full  flex align-items-center">
                                    <img src="../../../images/admin/empty.png" alt="Нет картинки" class="custom-img h-64 " />
                                </div>
                            </div>
                        </template>
                        <template #title>
                            <div class="title text-center text-900">{{ service.title }}</div>
                        </template>



                    </Card>
                </div>
            </div>
            </div>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import ServiceService from '../../services/ServiceService.js';
import {onMounted, computed, onUnmounted} from "vue";
import Card from "primevue/card"
import router from "../../router";

const serviceService = new ServiceService();
const store = useStore();
//
const services = computed(()=>store.getters['serviceModule/services']);


//methods
const click = (id) =>{
   router.push( `/service/${id}`)
};

const fillServices = async () =>{
    await serviceService.getServices().then(data => {
        store.dispatch('serviceModule/fillServices', data.data);
    })
};

onMounted(()=>{

    fillServices();

})
onUnmounted(()=>{
    store.dispatch('serviceModule/clearStore');

})

</script>

<style scoped lang="scss">
.title{
    font-size: 1rem;
    line-height: 1rem;
}

.custom-img{
    object-fit: fill;
}
.card-container{
    margin-right: 10px;
    margin-bottom: 30px;
    max-width: 28%;
    min-width: 28%;
}
.page-wrapper{
    padding-top: 6rem;
    margin: 0 auto;
    max-width: 1300px;

}
.description{

    word-wrap: break-word;
}
.content_wrapper{
    display: flex;
}
.container__wrapper{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    justify-items: flex-end;
}

@media only screen and (max-width: 1020px) {
    .container__wrapper{
        justify-content: space-evenly;


    }
    .card-container{
        max-width: 40%;
        min-width: 40%;
        margin-bottom: 20px;
        margin-right: 20px;
    }
}
@media only screen and (max-width: 620px) {
    .card-container{
        max-height: 45vh;
        max-width: 80%;
        min-width: 80%;
        margin-bottom: 10px;
    }

}
.custom-img{
    border-radius: 40px 40px 0 0;
}
.card_wrapper{
    background-color: rgba(255,255,255,0.8);
    cursor: pointer;
    transition: .2s all ease-out;
    border-radius: 40px;
}
.card_wrapper:hover{
    cursor: pointer;
    background-color: rgba(255,255,255,0.7);
}

</style>
