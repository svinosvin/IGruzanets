<template>
    <div
        class="relative pt-14 pb-32 w-full flex justify-center page-wrapper"
        style="min-height: 75vh;"
    >
        <div class="flex w-full justify-center ">

            <div class="container__wrapper w-full ">
                    <Card v-if="service.id" class="card_wrapper w-full cursor-pointer" @click="click(service.id)"  >
                        <template #header>
                            <div class="flex h-full header__wrapper border-b-2">
                                <div class=" flex h-full ">
                                    <div class=" h-full  flex justify-start" v-if="service.img!=null">
                                        <img :src="`${service.img}`" alt="Картинка" class="custom-img w-64  h-72  " />
                                    </div>
                                    <div v-else class="h-full  flex justify-start">
                                        <img src="../../../images/admin/empty.png" alt="Нет картинки" class="custom-img w-64  h-72 " />
                                    </div>
                                </div>
                                <div class="title font-bold pb-5 pr-2.5 text-center text-4xl">{{ service.title }}</div>
                            </div>

                        </template>
                        <template #title>
                        </template>
                        <template #content>
                            <div class="w-full">
                                <div class="description__header text-2xl border-b-2 font-bold">
                                    Описание:
                                </div>
                                <div class="description__text text-xl border-b-2 pt-5 description">
                                    <p>
                                        {{service.description}}
                                    </p>
                                </div>
                                <div v-if="service.resources.length > 0">

                                <div  class="description__header text-2xl pt-5 border-b-2 font-bold">
                                    Используемые ресурсы:
                                </div>
                                <div class="description__text text-xl font-bold border-b-2 pt-5">
                                    <ol>
                                        <li class="resources pb-2.5" v-for="resource in service.resources">
                                            {{resource.title}};
                                            <ul>
                                                <li class="font-light sub_resources" v-for="sub_resource in resource.sub_resources">
                                                    {{sub_resource.title}}
                                                </li>
                                            </ul>
                                        </li>
                                    </ol>
                                </div>
                                </div>

                                <div class="text-xl pt-6 border-b-2 font-bold">
                                    Цена за кг:
                                </div>
                                <div class="text-xl font-bold border-b-2 pt-5">
                                    {{service.price_one_unit}} руб.
                                </div>
                            </div>
                            <div class="button w-full ">
                                <Button  class="custom-button" icon="pi pi-check" label="Оформить заказ" @click="handleOpenDialog" />
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
            </div>
    <UserOrderDialog v-model:visible="openDialog" @close="handleCloseDialog"></UserOrderDialog>

</template>

<script setup>
import {useStore} from "vuex";
import ServiceService from '../../services/ServiceService.js';
import {onMounted, computed, onUnmounted, ref} from "vue";
import Card from "primevue/card"
import { useRoute } from 'vue-router'
import router from "../../router";
import UserOrderDialog from "../../components/Dialogs/ClientDialogs/UserOrderDialog.vue";
const route = useRoute()
const serviceService = new ServiceService();
const store = useStore();
//
const service = computed(()=>store.getters['serviceModule/activeService']);

const openDialog = ref(false);

const handleOpenDialog = async () =>{
    openDialog.value = true;
}
const handleCloseDialog = async () =>{
    openDialog.value = false;
}

//methods
const click = async (id) =>{
   console.log(id)
};



onMounted(async ()=>{
    let id = parseInt(route.params.id);
    await serviceService.getService(id).then(data=>{
        store.dispatch('serviceModule/setActiveService', data.data);
    }).catch((err)=>{
        router.back();
    })

})
onUnmounted(()=>{
    store.dispatch('serviceModule/clearStore');
})

</script>

<style scoped lang="scss">
.button{
    display:  flex;
    justify-content: flex-end;
    padding-top: 1rem;
}

ol{
    list-style-type: decimal;
    list-style-position: inside;
}

ul{
    list-style-type: disc;
    list-style-position: inside;
}
.header__wrapper{
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
}
.custom-button{
    background-color: #1a1a59;
    animation: ease-out 3ms;
    border: none;
}
.custom-button:hover{
    background-color: #3f4ae7;
}
.title{
    line-height: 1rem;
}

.custom-img{
border-radius: 40px 0 0 0 ;
}

.card_wrapper{
    background-color: rgba(235, 190, 255, 0.63);
    color: #000000;
    transition: .2s all ease-out;
    border-radius: 40px 40px 40px 40px;
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
    .title{
        @apply text-xl;
    }
    .description__header{
        font-size: 90%;
    }
    .description__text{
        font-size: 90%;
    }
    .button .custom-button{
        font-size: 90%;
    }
    .description{
        font-size: 0.85rem;
    }
    .custom-img{
        @apply w-52 h-52;}

}
@media only screen and (max-width: 620px) {
    .custom-img{
        @apply w-44 h-44;}

    .description__header{
        font-size: 90%;
    }
    .description__text{
        font-size: 90%;
    }
    .card-container{
        max-height: 45vh;
        max-width: 80%;
        min-width: 80%;
        margin-bottom: 10px;
    }
    .title{
        font-size: 1rem;
    }


}

</style>
