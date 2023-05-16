<template>
    <div
        class="relative pt-14 pb-32 w-full flex justify-center page-wrapper"
        style="min-height: 75vh;"
    >
        <div class="content_wrapper" v-if="loaded">

            <div class="bg-white  w-full">
                <div class="text-3xl font-bold w-full p-10 border-b-2" >

                    Авто
                </div>
                <Carousel  class="w-full" :value="autos" :numVisible="3" :numScroll="3" :responsiveOptions="responsiveOptions">
                    <template #item="slotProps">
                        <div class="border-1 surface-border border-round m-2 text-center py-5 px-3">
                            <div class="mb-3">
                                <div v-if="slotProps.data.img!=null">
                                    <img :src="`${slotProps.data.img}`" :alt="Картинка" class="w-52 h-52  mx-auto" />
                                </div>
                                <div v-else class="text-center">
                                    <img src="../../../images/admin/empty.png" alt="Нет картинки" class="w-24 h-24  mx-auto" />
                                    <div class="font-bold">No image</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ slotProps.data.mark }}</h4>
                                <h6 class="mt-0 mb-3">{{ slotProps.data.max_weight }}т. Максимальная грузоподъемность</h6>
                                <!--                        <Tag :value="slotProps.data.inventoryStatus" :severity="getSeverity(slotProps.data.inventoryStatus)" />-->
                                <div class="mt-5">
                                    <Button icon="pi pi-search" rounded class="mr-2" />
                                    <Button icon="pi pi-star-fill" rounded severity="success" class="mr-2"/>
                                </div>
                            </div>
                        </div>
                    </template>
                </Carousel>

            </div>
            <div class="bg-white mt-10  w-full">
                <div class="text-3xl font-bold w-full p-10 border-b-2" >
                    Водители
                </div>
                <Carousel  class="w-full" :value="drivers" :numVisible="3" :numScroll="3" :responsiveOptions="responsiveOptions">
                    <template #item="slotProps">
                        <div class="border-1 surface-border border-round m-2 text-center py-5 px-3">
                            <div class="mb-3">
                                <div v-if="slotProps.data.img!=null">
                                    <img :src="`${slotProps.data.img}`" alt="Картинка" class="w-52 h-52  mx-auto" />
                                </div>
                                <div v-else class="text-center">
                                    <img src="../../../images/admin/empty.png" alt="Нет картинки" class="w-24 h-24  mx-auto" />
                                    <div class="font-bold">No image</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ slotProps.data.name }}</h4>
                                <h6 class="mt-0 mb-3">{{ slotProps.data.first_name }}</h6>
                                <!--                        <Tag :value="slotProps.data.inventoryStatus" :severity="getSeverity(slotProps.data.inventoryStatus)" />-->
                                <div class="mt-5">
                                    <Button icon="pi pi-search" rounded class="mr-2" />
                                    <Button icon="pi pi-star-fill" rounded severity="success" class="mr-2"/>
                                </div>
                            </div>
                        </div>
                    </template>
                </Carousel>
            </div>
        </div>
        <div v-else class="w-full">

            <h5>Rectangle</h5>
            <Skeleton class="w-full p-10 mb-2">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-10 p-5">Происходит загрузка</Skeleton>

            <Skeleton class="w-full p-10 mb-2">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>
            <Skeleton class="w-full mb-2 p-5">Происходит загрузка</Skeleton>


        </div>
    </div>

</template>

<script setup>
import Skeleton from 'primevue/skeleton'
import Carousel from 'primevue/carousel';

import {useStore} from "vuex";
import {onMounted, computed, onUnmounted} from "vue";
import Card from "primevue/card"
import router from "../../router";
import AutoService from '../../services/AutoService'
import DriverService from '../../services/DriverService';
import {ref} from "vue";

const driverService = new DriverService();
const autoService = new AutoService();

const store = useStore();
//
const drivers = computed(()=>store.getters['driverModule/drivers']);
const autos = computed(()=>store.getters['autoModule/autos']);
const loaded = ref(false);

//methods

const fillDrivers = async () =>{

    await driverService.getDrivers().then(data => {
        let newData = data.data.filter(x => x.img != null)
        console.log(newData);
        store.dispatch('driverModule/fillDrivers', newData);
    })
};
const fillAutos = async () =>{
    await autoService.getAutos().then(data => {

        let newData = data.data.filter(x => x.img != null)
        console.log(newData);
        store.dispatch('autoModule/fillAutos', newData);
    })
};
onMounted(async ()=>{

    await fillAutos();
    await fillDrivers();
    loaded.value = true;


})
onUnmounted(()=>{
    store.dispatch('driverModule/clearStore');
    store.dispatch('autoModule/clearStore');

})

</script>

<style scoped lang="scss">

.content_wrapper{
    display: flex;
    flex-direction: column;
    justify-content: space-between;

}
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
