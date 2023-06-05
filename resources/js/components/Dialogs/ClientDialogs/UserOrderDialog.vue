<template>
    <Dialog :modal="true" class="bg-gray-800" :style="{width: '50vw'}">
        <template #header>
            <h3 class="text-3xl font-bold ">Заказ</h3>
        </template>
        <div class="flex-column   pt-2 justify-center">
            <div >
                <div class="flex pb-2  header__wrapper border-b-3 mb-3">
                    <div class="first__brick pl-4 brick__wrapper pr-10  pt-4 pb-4">
                        <h2 class="w-full font-bold brick__header">Услуга:</h2>
                        <div class="w-full">{{activeService.title}}</div>
                    </div>
                    <div class="second__brick pl-4  brick__wrapper pr-10 pt-4 pb-4">
                        <h2 class="w-full font-bold brick__header">Тип услуги:</h2>
                        <div class="w-full">{{activeService.service_type.title}}</div>
                    </div>
                    <div class="third__brick pl-4   brick__wrapper pr-10 pt-4 pb-4">
                        <h2 class="w-full font-bold brick__header">Итого: </h2>
                        <div class="w-full">{{activeOrder.total_price}} руб.</div>
                    </div>
                </div>
                <div class="stroke__wrapper w-full pt-4 pb-4">
                    <h2 class="font-bold stroke__header">Выберите категорию мусора</h2>
                    <Dropdown v-model="activeOrder.resource" :options="[{'id':null,'title':'По умолчанию',}, ...activeService.resources]"
                              optionLabel="title" class="w-full"  placeholder="По умолчанию" :filter="true" filterPlaceholder="Найти категорию">
                    </Dropdown>
                </div>
                <div class="flex w-full flex-wrap mb-3">
                    <div class="mb-3 w-full">
                        <h2 class="font-bold">Предпочтительная дата и время</h2>
                        <VueDatePicker v-model="activeOrder.order_at"    :month-change-on-scroll="false"  locale="ru" placeholder="Заказы в конкретную дату" cancelText="отменить" format="dd-MM-yy HH:mm"    :min-date="new Date()"  selectText="выбрать" />
                        <!--                            <Calendar class="w-full" v-model="activeOrder.order_at" :minDate="new Date()" dateFormat="dd-mm-yy"  :manualInput="false" showIcon showTime hourFormat="24" />-->
                    </div>
                    <div class="w-half mr-2" >
                        <h2 class="font-bold">Введите ваш телефон</h2>
                        <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="activeOrder.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                    </div>
                    <div class="mb-3">
                        <h2 class="font-bold">Масса отходов.</h2>
                        <InputNumber  @input="onChangePrice" class="w-full " @focusout="onChangePrice" @change="onChangePrice" v-model="activeOrder.weight" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="5" :min="5" :max="7000" />
                    </div>

                </div>
                <!--                v-if=""-->
                <div class="mb-3 stroke__wrapper">
                    <h2 class=" font-bold stroke__header">Введите адрес</h2>
                    <InputText class="w-full" v-model="activeOrder.address"></InputText>
                </div>
                <div class="mb-3">
                    <h2 class="font-bold stroke__header">Введите ваше имя</h2>
                    <InputText class="w-full" v-model="activeOrder.name"/>
<!--                    <MultiSelect v-model="activeService.resources"  :options="resources"  optionLabel="title" placeholder="Выберите ресурсы" :filter="true" class="multiselect-custom w-full md:w-20rem"-->
<!--                                 emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов"></MultiSelect>-->
                </div>
                <div class="mb-3">
                    <h2 class="font-bold">Комментарий к заказу</h2>
                    <Textarea v-model="activeOrder.notice" class="w-full" :autoResize="true" rows="2" cols="50" />
                </div>
            </div>



        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">

                <div>
                    <Button label="Отмена" icon="pi pi-times" class="p-button-text" @click="handleClose"/>
                    <Button label="Заказать" icon="pi pi-check" class="p-button" autofocus @click="acceptChanges"/>
                </div>
            </div>
        </template>
    </Dialog>
</template>

<script setup>

import {computed, onMounted, ref, watch} from "vue";
import {useStore} from "vuex";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import VueDatePicker from '@vuepic/vue-datepicker';

import InputNumber from 'primevue/inputnumber';
import ServiceService from "../../../services/ServiceService";
import OrderService from "../../../services/OrderService";
import Calendar from 'primevue/calendar';

//uses
const toast = useToast();
const confirm = useConfirm();
const store = useStore();

const emit = defineEmits(['close'])

const orderService = new OrderService();


//computed
const activeService = computed(()=>store.getters['serviceModule/activeService']);
const resources = computed(()=>store.getters['resourceModule/resources']);
const serviceTypes = computed(()=>store.getters['serviceModule/service_types']);
const activeOrder = computed(()=>store.getters['orderModule/activeOrder']);
const currentUser = computed(()=>store.getters['authUser/currentUser']);


//methods

const handleClose = () => {
    emit('close');
}

const acceptChanges = async () => {
    await confirm.require({
        message:`Вы точно хотите обновить данные заказа?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
                await toast.add({
                    severity:'success',
                    summary: 'Ждите подтверждения заказа, с вами свяжутся!',
                    detail:'',
                    life: 3000
                })
            // await serviceService.deleteService(id);
            await orderService.createOrder( {
                driver_id : activeOrder.value.driver !=null ? activeOrder.value.driver.id : null,
                user_id : activeOrder.value.user !=null ? activeOrder.value.user.id : null,
                auto_id : activeOrder.value.auto !=null ? activeOrder.value.auto.id : null,
                resource_id: activeOrder.value.resource !=null ? activeOrder.value.resource.id : null,
                order_types_id : 1,
                service_id : activeService.value.id,
                tel_number : activeOrder.value.tel_number,
                name :  activeOrder.value.name,
                address : activeOrder.value.address,
                weight :  activeOrder.value.weight,
                total_price : activeOrder.value.total_price,
                order_at : activeOrder.value.order_at,
                notice : activeOrder.value.notice,
            }).then(data => {
                store.dispatch('orderModule/clearActiveOrder');
                handleClose();
            })
            // await fillServices();
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

const onChangePrice = async () =>{
    activeOrder.value.total_price = activeService.value.price_one_unit * activeOrder.value.weight;
    console.log(activeOrder.value.total_price)
}
onMounted(()=>{


    onChangePrice();
    console.log(serviceTypes.value);
})
</script>

<style scoped>
.header__wrapper{
    display: flex;
    justify-content: space-between;
}
.border-b-3{
    border-bottom: 3px solid lightslategray;
}
.border-t-3{
    border-top: 3px solid lightslategray;

}
.brick__wrapper{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    width: 30%;
}
.first__brick{
    border-radius: 14px;
    background-color: rgba(251, 191, 36)
}
.second__brick{
    border-radius: 14px;
    background-color: rgba(192, 38, 211, 0.4)
}
.third__brick{
    border-radius: 14px;
    background-color: rgba(59, 130, 246, 0.5)
}
.w-half{
    max-width: 50%;
    width: 50%;
}
</style>
