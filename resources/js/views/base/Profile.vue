<template>
    <div
        class="relative pt-14 pb-32 w-full flex justify-center page-wrapper"
        style="min-height: 75vh;"
    >
        <div class="flex w-full">

            <div class="container__wrapper flex justify-center w-full ">
                <Card  class="card_wrapper w-full"  >
                    <template #header>
                        <div>
                        <div class="flex w-full h-full header__wrapper border-b-2 pr-12">
                            <div class="flex justify-center w-full h-full">
                                <div class=" h-full flex justify-start mr-10 p-10">
                                    <img src="../../../images/admin/user.jpg" alt="Нет картинки" class="custom-img w-64  h-72 " />
                                </div>
                            </div>
                            <div class="w-full p-10">
                                <div class="mb-6 w-full">
                                    <h2>Имя</h2>
                                    <InputText class="w-full" v-model="user.name"></InputText>
                                </div>
                                <div class="mb-6">
                                    <h2>Фамилия</h2>
                                    <InputText class="w-full" v-model="user.first_name"></InputText>
                                </div>
                                <div class="mb-6">
                                    <h2>Отчество </h2>
                                    <InputText class="w-full" v-model="user.patronymic"></InputText>
                                </div>
                                <div class="mb-6">
                                    <h2>Email </h2>
                                    <InputText class="w-full" v-model="user.email"></InputText>
                                </div>

                                <div class="mb-6">
                                    <h2>Телефон</h2>
                                    <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="user.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                                </div>
<!--                                <div class="title font-bold pb-5 pr-2.5 text-center text-3xl">{{ user.name }}</div>-->
<!--                                <div class="title font-bold pb-5 pr-2.5 text-center text-3xl">{{ user.first_name }}</div>-->
<!--                                <div class="title font-bold pb-5 pr-2.5 text-center text-3xl">{{ user.patronymic}}</div>-->
<!--                                <div class="title font-bold pb-5 pr-2.5 text-center text-3xl">{{ user.tel_number}}</div>-->
<!--                                <div class="title font-bold pb-5 pr-2.5 text-center text-3xl">{{ user.company!=null ? user.company.title : 'нет компании' }}</div>-->
                                    <div class="button w-full ">
                                        <Button @click="dataUpdate" class="custom-button" icon="pi pi-check" label="Изменить" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </template>
                    <template #title>
                    </template>
                    <template #content>
                        <h2>
                            Последние заказы
                        </h2>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import {computed, onMounted} from "vue";
import Card from "primevue/card";
import UserService from "../../services/UserService";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";


//uses
const confirm = useConfirm();
const toast = useToast();
const store = useStore();
const userService = new UserService();
const user = computed(()=> store.getters["authUser/currentUser"])


const getData = ()=>{
    store.dispatch('authUser/getDataUser');
}
const dataUpdate = async ()=>{

    await confirm.require({
        message:`Вы точно хотите изменить данные?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await userService.updateUserData(user.value.id, {

                email: user.value.email,
                name: user.value.name,
                first_name: user.value.first_name,
                patronymic: user.value.patronymic,
                tel_number: user.value.tel_number,
            });

            toast.add({
                severity:'success',
                summary: 'Данные обновлены',
                detail:'Данные пользователя были обновлены!',
                life: 3000
            })
        await getData();
        },
        reject: () => {
            //callback to execute when user rejects the action
        },
        onShow: () => {
            //callback to execute when dialog is shown
        },
        onHide: () => {
            //callback to execute when dialog is hidden
        }
    });

}

onMounted(()=>{
    getData();
})

</script>

<style scoped>
.content_wrapper{
    display: flex;
}

.container__wrapper{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    justify-items: flex-end;
}
.page-wrapper{
    padding-top: 6rem;
    margin: 0 auto;
    max-width: 1300px;
}
.custom-img{
    border-radius: 50%;
    border: 2px solid black;
}
.button{
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>
