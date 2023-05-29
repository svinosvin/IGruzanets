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
                        <DataTable  style=""  :class="`p-datatable-sm`"
                                    :value="user.orders" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="3"
                                    showGridlines
                                    scrollable
                                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                    :rowsPerPageOptions="[3,10]"
                        >
                            <template #header>
                                <span class="text-3xl">Заказы</span>
                            </template>

                            <Column header="Инфо">
                                <template #body="slotProps">

                                    <div class="flex-col w-full">

                                        <div class="w-full text-center font-bold text-xl">
                                            Дата:{{slotProps.data.order_at}}
                                        </div>
                                        <Accordion class="pb-10 w-full" :multiple="true" :activeIndex="[]">
                                            <AccordionTab header="Данные заказа">
                                                <div class="flex flex-col">
                                                    <div class="w-full mb-2 flex border-b-2">
                                                        <h2 class="font-bold  w-half mr-2">Имя: </h2>
                                                        <div class="w-full pt-1 pb-1">
                                                            <div class="w-full">{{slotProps.data.name}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-2 flex border-b-2">
                                                        <h2 class="font-bold w-half mr-2">Адрес: </h2>
                                                        <div class="w-full pt-2 pb-2">
                                                            <div class="w-full pt-1 pb-1">
                                                                <div class="w-full">{{slotProps.data.address}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-2  flex border-b-2">
                                                        <h2 class="font-bold w-half mr-2">Телефон: </h2>
                                                        <div class="w-full pt-2 pb-2">
                                                            <div class="w-full">{{slotProps.data.tel_number}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-2 flex border-b-2">
                                                        <h2 class="font-bold w-half mr-2">Дата: </h2>
                                                        <div class="w-full pt-2 pb-2">
                                                            <div class="w-full">{{slotProps.data.order_at}}</div>

                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-2 flex border-b-2">
                                                        <h2 class="font-bold w-half  mr-2">Общий вес (кг): </h2>
                                                        <div class="w-full pt-2 pb-2">
                                                            <div class="w-full">{{slotProps.data.weight}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-2 flex border-b-2">
                                                        <h2 class="font-bold w-half  mr-2">Услуга: </h2>
                                                        <div class="w-full pt-2 pb-2">
                                                            <div class="w-full">{{slotProps.data.service.title}}</div>
                                                        </div>

                                                    </div>
                                                    <div class="w-full mb-2 pt-5 pb-5 flex border-b-2 ">
                                                        <h2 class="font-bold w-half  mr-2"> Цена за один кг в данной услуге:</h2>
                                                        <div class="w-full text-xl font-bold">
                                                            {{slotProps.data.service.price_one_unit}} р.
                                                        </div>
                                                    </div>

                                                    <div class="w-full mb-10 flex-col pb-2 border-b-2">
                                                        <div class="font-bold text-3xl pb-4">Машина</div>
                                                        <div v-if="slotProps.data.auto!=null" class="flex  flex-col">
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold w-half mr-2">Марка: </h2>
                                                                <div>{{slotProps.data.auto.mark}}</div>
                                                            </div>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold w-half  mr-2">Грузоподъемность: </h2>
                                                                <div>{{slotProps.data.auto.max_weight}} т.</div>
                                                            </div>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold w-half mr-2">Категория: </h2>
                                                                <div>{{slotProps.data.auto.auto_category.title}}</div>
                                                            </div>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold w-half mr-2">Номера: </h2>
                                                                <div>{{slotProps.data.auto.car_numbers}}</div>
                                                            </div>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold w-half mr-2">Услуга машины: </h2>
                                                                <div>{{slotProps.data.auto.service.title}}</div>

                                                            </div>
                                                        </div>
                                                        <div class="w-full flex-col" v-else>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold mr-2">Машина: </h2>
                                                                <div>Еще не подобрана</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mb-10 flex-col pb-2 ">
                                                        <div class="font-bold text-3xl pb-4">Водитель</div>
                                                        <div v-if="slotProps.data.driver!=null" class="flex flex-col">
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold mr-2">ФИО: </h2>
                                                                <div>{{`${slotProps.data.driver.first_name}  ${slotProps.data.driver.name}  ${slotProps.data.driver.patronymic}`}}</div>
                                                            </div>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold mr-2">Телефон: </h2>
                                                                <div>{{slotProps.data.driver.tel_number}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="w-full flex-col" v-else>
                                                            <div class="w-full flex">
                                                                <h2 class="font-bold mr-2">Водитель: </h2>
                                                                <div>Еще не подобран</div>
                                                            </div>
                                                            <div class="w-full mt-3 flex">
                                                                <div class="mr-2">
                                                                    <Button icon="pi pi-search" label="Подобрать другого водителя" class="p-button-rounded mr-2 p-button-success" @click="findDriver(slotProps.data.id)"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="w-full mb-2 flex border-b-2">
                                                    <h2 class="font-bold text-2xl w-half mr-2">Итого: </h2>
                                                    <div class="w-full text-2xl">{{slotProps.data.total_price}} руб.</div>
                                                </div>

                                            </AccordionTab>
                                        </Accordion>
                                    </div>

                                </template>

                            </Column>
                            <Column field="order_type.title" header="Статус заказа" style="max-width:8rem;">
                            </Column>


                            <template #footer> В сумме {{ orders ? orders.length : 0 }} заказов. </template>
                        </DataTable>


                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import {computed, onMounted, ref} from "vue";
import Card from "primevue/card";
import UserService from "../../services/UserService";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';

import OrderService from '../../services/OrderService';
const orderService = new OrderService();


//uses
const confirm = useConfirm();
const toast = useToast();
const store = useStore();
const userService = new UserService();
const user = computed(()=> store.getters["authUser/currentUser"])
const loaded = ref(false)
const orders = computed(()=>store.getters['orderModule/orders']);


const getData =  ()=>{
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

onMounted( ()=>{
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
