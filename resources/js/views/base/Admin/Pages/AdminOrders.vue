<template>
    <AdminPageWrapper headerPage="Заказы">
        <template v-slot:header>
            <Toolbar class="mb-4 flex flex-wrap">
                <template #start>
                    <Button label="Добавить" icon="pi pi-plus" class="p-button-success mr-5" @click="handleOpenDialog" />
                </template>
                <template #end>
                </template>
            </Toolbar>
        </template>
        <template v-slot:main>
            <DataTable style=""  :class="`p-datatable-sm`"
                       :value="orders" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="3"
                       showGridlines
                       scrollable
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                       :rowsPerPageOptions="[3,10]"
                       @row-dblclick="dblclickHandler"
            >
                <template #header>
                    <span class="text-3xl">Заказы</span>
                </template>

                <Column header="Инфо">
                    <template #body="slotProps">
                        <Accordion class="pb-10 w-full" :multiple="true" :activeIndex="[]">
                            <AccordionTab header="Данные заказа">
                                <div class="flex flex-col">
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold  w-half mr-2">Имя: </h2>
                                        <div class="w-full pt-1 pb-1">
                                            <InputText class="w-full" v-model="slotProps.data.name"></InputText>
                                        </div>
                                    </div>
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold w-half mr-2">Адрес: </h2>
                                        <div class="w-full pt-2 pb-2">
                                            <InputText class="w-full" v-model="slotProps.data.address"></InputText>
                                        </div>
                                    </div>
                                    <div class="w-full mb-2  flex border-b-2">
                                        <h2 class="font-bold w-half mr-2">Телефон: </h2>
                                        <div class="w-full pt-2 pb-2">
                                            <InputText class="w-full" v-model="slotProps.data.tel_number"></InputText>

                                        </div>
                                    </div>
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold w-half mr-2">Дата: </h2>
                                        <div class="w-full pt-2 pb-2">
                                            <Calendar class="w-full" v-model="slotProps.data.order_at" :minDate="new Date()" dateFormat="dd-mm-yy"  :manualInput="false" showIcon showTime hourFormat="24" />
                                        </div>
                                    </div>
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold w-half  mr-2">Общий вес (кг): </h2>
                                        <div class="w-full pt-2 pb-2">
                                            <InputNumber class="w-full " v-model="slotProps.data.weight" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="5" :min="5" :max="7000" />
                                        </div>
                                    </div>
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold w-half  mr-2">Услуга: </h2>
                                        <div class="w-full pt-2 pb-2">{{slotProps.data.service.title}}</div>
                                    </div>
                                    <div class="w-full mb-10 flex-col border-b-2">
                                        <h2 class="font-bold w-half mr-2">Комментарий к заказу: </h2>
                                        <div class="pt-2 pb-2 w-full">
                                            <Textarea v-model="slotProps.data.notice" class="w-full" :autoResize="true" rows="2" cols="50" readonly />
                                        </div>
                                    </div>
                                    <div class="w-full mb-2 flex border-b-2">
                                        <h2 class="font-bold text-xl w-half mr-2">Итого: </h2>
                                        <div class="w-full">{{slotProps.data.total_price}} руб.</div>
                                    </div>
                                    <div class="w-full mb-2 flex flex-end">
                                        <Button icon="pi" label="Изменить" class="p-button-rounded mr-2 p-button" @click=""/>
                                    </div>
                                </div>

                            </AccordionTab>
                            <AccordionTab  :header='slotProps.data.user!=null ? "Заказчик: авторизирован" : "Заказчик: не авторизирован" '>
                                <div v-if="slotProps.data.user!=null" class="flex flex-col">
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">ФИО водителя: </h2>
                                        <div>{{`${slotProps.data.user.first_name ?? ''}  ${slotProps.data.user.name}  ${slotProps.data.user.first_name ?? ''}`}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">Телефон: </h2>
                                        <div>{{slotProps.data.user.tel_number}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">Email: </h2>
                                        <div>{{slotProps.data.user.email}}</div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="w-full flex">

                                    </div>
                                </div>
                            </AccordionTab>
                            <AccordionTab :header='slotProps.data.driver!=null ? "Водитель: подобран" : "Водитель: не подобран" '>
                                <div v-if="slotProps.data.driver!=null" class="flex flex-col">
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">ФИО водителя: </h2>
                                        <div>{{`${slotProps.data.driver.first_name}  ${slotProps.data.driver.name}  ${slotProps.data.driver.patronymic}`}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">Телефон: </h2>
                                        <div>{{slotProps.data.driver.tel_number}}</div>
                                    </div>
                                    <div class="w-full mt-3 flex">
                                        <div class="mr-2">
                                            <Button icon="pi pi-search" label="Подобрать другого водителя" class="p-button-rounded mr-2 p-button-success" @click="findDriver(slotProps.data.id)"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full flex-col" v-else>
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">Водитель: </h2>
                                        <div>Не подобран</div>
                                    </div>
                                    <div class="w-full mt-3 flex">
                                        <div class="mr-2">
                                            <Button icon="pi pi-search" label="Подобрать другого водителя" class="p-button-rounded mr-2 p-button-success" @click="findDriver(slotProps.data.id)"/>
                                        </div>
                                    </div>
                                </div>
                            </AccordionTab>
                            <AccordionTab :header='slotProps.data.auto!=null ? "Авто: подобрано" : "Авто: не подобрано" '>
                                <div v-if="slotProps.data.auto!=null" class="flex flex-col">
                                    <div class="w-full flex">
                                        <h2 class="font-bold w-half mr-2">Марка машины: </h2>
                                        <div>{{slotProps.data.auto.mark}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold w-half  mr-2">Грузоподъемность машины: </h2>
                                        <div>{{slotProps.data.auto.max_weight}} т.</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold w-half mr-2">Категория машины: </h2>
                                        <div>{{slotProps.data.auto.auto_category.title}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold w-half mr-2">Номера машины: </h2>
                                        <div>{{slotProps.data.auto.car_numbers}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <h2 class="font-bold w-half mr-2">Услуга машины: </h2>
                                        <div>{{slotProps.data.auto.service.title}}</div>

                                    </div>
                                    <div class="w-full flex">
                                        <div class="mr-2">
                                            <Button icon="pi pi-search" label="Подобрать другого машину" class="p-button-rounded mr-2 p-button-success" @click="findCar(slotProps.data.id)"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex-col" v-else>
                                    <div class="w-full flex">
                                        <h2 class="font-bold mr-2">Машина: </h2>
                                        <div>Не подобрана</div>
                                    </div>
                                    <div class="w-full mt-3 flex">
                                        <div class="mr-2">
                                            <Button icon="pi pi-search" label="Подобрать машину" class="p-button-rounded mr-2 p-button-success" @click="findCar(slotProps.data.id)"/>
                                        </div>
                                    </div>
                                </div>

                            </AccordionTab>
                        </Accordion>
                    </template>
                </Column>
                <Column field="order_type.title" header="Статус заказа" style="max-width:8rem;">
                </Column>

                    <Column :exportable="false" style="max-width: 12rem; min-width:6rem">
                        <template #body="slotProps">
                            <div class="flex-col">
                                <div class="mb-6">
                                    <Button icon="pi pi-pencil" label="Принять" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                                </div>
                                <div class="">
                                    <Button icon="pi pi-pencil" label="Отклонить" class="p-button-rounded mr-2 p-button-danger" @click="handleEditDialog(slotProps.data)"/>
                                </div>
                            </div>


                        </template>
                    </Column>

                <template #footer> В сумме {{ orders ? orders.length : 0 }} заказов. </template>
            </DataTable>

        </template>
    </AdminPageWrapper>
</template>

<script setup>
import Calendar from 'primevue/calendar';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import InputNumber from 'primevue/inputnumber';
import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import OrderService from '../../../../services/OrderService';
import OrderTypeService from "../../../../services/OrderTypeService";
import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';

// import ServiceDialog from '../../../../components/Dialogs/ServiceDialog.vue';



const orderService = new OrderService();
const orderTypeService = new OrderTypeService();

const toast = useToast();
const confirm = useConfirm();

//refs
const store = useStore();
//uses

//refs


//computed
const activeOrder = computed(()=>store.getters['orderModule/activeOrder']);
const orders = computed(()=>store.getters['orderModule/orders']);


const setActiveOrder = (data)=>{
    store.dispatch('orderModule/setActiveOrder', data);
}



const fillData = async () =>{
    await orderService.getOrders().then(data => {
        store.dispatch('orderModule/fillOrders', data.data);
    })
    await orderTypeService.getOrderTypes().then(data => {
        store.dispatch('orderModule/fillOrderTypes', data.data);
    })

};

const clearActiveOrder = ()=>{
    store.dispatch('orderModule/clearActiveOrder');
}
const findDriver = async (id) =>{
console.log(id);
    await orderService.findDriver(id).then(data => {
        console.log(data.data)
        findOrder(id);
    })

}

const findCar = async (id) =>{
    await orderService.findCar(id).then(data => {
        console.log(data.data)
        findOrder(id);
    })
}
const findOrder = async (id)=>{
    await orderService.getOrder(id).then(data => {

        console.log(data.data)
        store.dispatch('orderModule/updateOrder', {id: id, data: data.data});
    })
}

//crud
const deleteService = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить Услугу №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            // await serviceService.deleteService(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Услуга успешно удалена!',
                life: 3000
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

//hooks
onMounted(() =>{
    fillData()
})

onUnmounted(()=>{
    store.dispatch('serviceModule/clearStore');
})

</script>

<style scoped>
 ol{
     list-style-type: decimal;
     list-style-position: inside;
 }

 ul{
     list-style-type: disc;
     list-style-position: inside;
 }
 .flex-end{
     display:flex;
     justify-content: flex-end;
 }
 .w-half{
     width: 50%;
 }
</style>
