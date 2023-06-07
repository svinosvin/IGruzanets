<template>
    <AdminPageWrapper headerPage="Заказы">
        <template v-slot:header>
            <Toolbar class="mb-4 flex flex-wrap">
                <template #start>
                    <div class="mr-5" >
                        <Dropdown @change="" v-model="orderType"  :options="[ ...orderTypes]"
                                  optionLabel="title" class="w-full"  placeholder="Выберите cтатус заказа" :filter="true">
                        </Dropdown>
                    </div>
                    <div class="mr-5">
                        <Dropdown @change="" v-model="serviceType"  :options="[ ...services]"
                                  optionLabel="title" class="w-full"  placeholder="Выберите тип услуги" :filter="true">
                        </Dropdown>
                    </div>
                    <div class="mr-5">
                        <VueDatePicker v-model="orderAt"    :month-change-on-scroll="false"  locale="ru" placeholder="Предпочтительная дата и время" cancelText="Отменить" format="dd-MM-yy HH:mm"  selectText="Выбрать" ></VueDatePicker>
                    </div>

                    <div >
                        <Button label="Сбросить" icon="pi pi-cross" class="p-button mr-5" @click="resetButton" />

                    </div>
                </template>
                <template #end>
<!--                    <Button label="Добавить" icon="pi pi-plus" class="p-button-success mr-5" @click="handleOpenDialog" />-->
                </template>
            </Toolbar>
        </template>
        <template v-slot:main>
            <DataTable  v-if="loaded" style=""  :class="`p-datatable-sm`"
                        :value="orders" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="3"
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

                        <div v-if="slotProps.data.order_type.id == 1" class="flex-col w-full">

                            <div class="w-full text-center font-bold text-xl">
                                Дата:{{slotProps.data.order_at}}
                            </div>
                            <Accordion class="pb-10 w-full" :multiple="true" :activeIndex="activeOrder.id == slotProps.data.id ? [0] : []">

                                <AccordionTab header="Данные заказа">
                                    <Form :validation-schema="schema"  validate-on-mount @submit="updateOrder">
                                    <div class="flex flex-col">
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold  w-half mr-2">Имя: </h2>
                                            <div class="w-full pt-1 pb-1">
                                                <InputText class="w-full" v-model="slotProps.data.name"></InputText>
                                                <ValidationComponent name="name" v-model="slotProps.data.name"></ValidationComponent>

                                            </div>
                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half mr-2">Адрес: </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <InputText class="w-full" v-model="slotProps.data.address"></InputText>
                                                <ValidationComponent name="address" v-model="slotProps.data.address"></ValidationComponent>

                                            </div>
                                        </div>
                                        <div class="w-full mb-2  flex border-b-2">
                                            <h2 class="font-bold w-half mr-2">Телефон: </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="slotProps.data.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                                                <ValidationComponent name="tel_number" v-model="slotProps.data.tel_number"></ValidationComponent>

                                            </div>
                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half mr-2">Дата: </h2>
                                            <div class="w-full pt-2 pb-2">

                                                <Calendar class="w-full" v-model="slotProps.data.order_at" :minDate="new Date()" dateFormat="dd-mm-yy"  :manualInput="false" showIcon showTime hourFormat="24" />
                                                <ValidationComponent name="order_at" v-model="slotProps.data.order_at"></ValidationComponent>

                                            </div>
                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half  mr-2">Общий вес (кг): </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <InputNumber  @input="onChangePrice(slotProps.data)" @focusout="onChangePrice(slotProps.data)" class="w-full " v-model="slotProps.data.weight" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="5" :min="5" :max="7000" />

                                            </div>
                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half  mr-2">Услуга: </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <Dropdown @change="onChangePrice(slotProps.data)" v-model="slotProps.data.service"  :options="[{'id': null, 'title': 'Выберите услугу', 'price_one_unit': 0}, ...services]"
                                                          optionLabel="title" class="w-full"  placeholder="Выберите тип услуги" :filter="true">
                                                </Dropdown>
                                                <ValidationComponent v-if="services.length>0 && slotProps.data.service!=null" name="service" v-model="slotProps.data.service.id"></ValidationComponent>

                                            </div>

                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half  mr-2">Категория мусора: </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <div v-if="slotProps.data.service.id!=null" class="w-full">
                                                <Dropdown  v-model="slotProps.data.resource" :options="[{'id':null,'title':'По умолчанию',}, ...slotProps.data.service.resources]"
                                                          optionLabel="title" class="w-full"  placeholder="По умолчанию" :filter="true" filterPlaceholder="Найти категорию">
                                                </Dropdown>
                                                <ValidationComponent v-if="slotProps.data.service.resources.length>0 && slotProps.data.resource!=null" name="resource" v-model="slotProps.data.resource.id"></ValidationComponent>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-full mb-2 pt-5 pb-5 flex border-b-2 ">
                                            <h2 class="font-bold w-half  mr-2"> Цена за один кг в данной услуге:</h2>
                                            <div class="w-full text-xl font-bold">
                                                {{slotProps.data.service.price_one_unit}} р.
                                            </div>
                                        </div>

                                        <div class="w-full mb-10 flex-col border-b-2">
                                            <h2 class="font-bold w-half mr-2">Комментарий к заказу: </h2>
                                            <div class="pt-2 pb-2 w-full">
                                                <Textarea v-model="slotProps.data.notice" class="w-full" :autoResize="true" rows="2" cols="50" readonly />
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
                                                <div class="w-full flex mt-2">
                                                    <div class="mr-2">
                                                        <Button icon="pi pi-search" label="Подобрать другую машину" class="p-button-rounded mr-2 p-button-success" @click="findCar(slotProps.data)"/>
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
                                                        <Button icon="pi pi-search" label="Подобрать машину" class="p-button-rounded mr-2 p-button-success" @click="findCar(slotProps.data)"/>
                                                    </div>
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
                                                <div class="w-full mt-3 flex">
                                                    <div class="mr-2">
                                                        <Button icon="pi pi-search" label="Подобрать другого водителя" class="p-button-rounded mr-2 p-button-success" @click="findDriver(slotProps.data)"/>
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
                                                        <Button icon="pi pi-search" label="Подобрать другого водителя" class="p-button-rounded mr-2 p-button-success" @click="findDriver(slotProps.data)"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full mb-10 flex-col ">
                                            <div v-if="slotProps.data.user!=null" class="flex flex-col">
                                                <div class="font-bold text-3xl pb-4">Аккаунт</div>
                                                <div class="w-full flex">
                                                    <h2 class="font-bold mr-2">ФИО: </h2>
                                                    <div>{{`${slotProps.data.user.first_name ?? ''}  ${slotProps.data.user.name}  ${slotProps.data.user.patronymic ?? ''}`}}</div>
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
                                                    <div class="font-bold text-3xl pb-4">Аккаунт: не авторизован</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold text-2xl w-half mr-2">Итого: </h2>
                                            <div class="w-full text-2xl">{{slotProps.data.total_price}} руб.</div>
                                        </div>
                                        <div class="w-full mb-2 flex flex-end">
                                            <Button icon="pi" label="Сохранить" class="p-button-rounded mr-2 p-button" @click="updateOrder(slotProps.data)"/>
                                        </div>
                                    </div>
                        </Form>

                                </AccordionTab>
                            </Accordion>
                        </div>
                        <div v-else class="flex-col w-full">

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
                                        <div class="w-full mb-2 flex border-b-2">
                                            <h2 class="font-bold w-half  mr-2">Категория мусора: </h2>
                                            <div class="w-full pt-2 pb-2">
                                                <div class="w-full">{{slotProps.data.resource != null ? slotProps.data.resource.title : 'По умолчанию' }}</div>
                                            </div>

                                        </div>
                                        <div class="w-full mb-2 pt-5 pb-5 flex border-b-2 ">
                                            <h2 class="font-bold w-half  mr-2"> Цена за один кг в данной услуге:</h2>
                                            <div class="w-full text-xl font-bold">
                                                {{slotProps.data.service.price_one_unit}} р.
                                            </div>
                                        </div>

                                        <div class="w-full mb-10 flex-col border-b-2">
                                            <h2 class="font-bold w-half mr-2">Комментарий к заказу: </h2>
                                            <div class="pt-2 pb-2 w-full">
                                                <Textarea v-model="slotProps.data.notice" class="w-full" :autoResize="true" rows="2" cols="50" readonly />
                                            </div>
                                        </div>
                                        <div class="w-full mb-10 flex-col pb-2 border-b-2">
                                            <div class="font-bold text-3xl pb-4">Машина</div>
                                            <div  class="flex  flex-col">
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

                                        </div>
                                        <div class="w-full mb-10 flex-col pb-2 ">
                                            <div class="font-bold text-3xl pb-4">Водитель</div>
                                            <div  class="flex flex-col">
                                                <div class="w-full flex">
                                                    <h2 class="font-bold mr-2">ФИО: </h2>
                                                    <div>{{`${slotProps.data.driver.first_name}  ${slotProps.data.driver.name}  ${slotProps.data.driver.patronymic}`}}</div>
                                                </div>
                                                <div class="w-full flex">
                                                    <h2 class="font-bold mr-2">Телефон: </h2>
                                                    <div>{{slotProps.data.driver.tel_number}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mb-10 flex-col ">
                                        <div v-if="slotProps.data.user!=null" class="flex flex-col">
                                            <div class="font-bold text-3xl pb-4">Аккаунт</div>
                                            <div class="w-full flex">
                                                <h2 class="font-bold mr-2">ФИО: </h2>
                                                <div>{{`${slotProps.data.user.first_name ?? ''}  ${slotProps.data.user.name}  ${slotProps.data.user.patronymic ?? ''}`}}</div>
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
                                                <div class="font-bold text-3xl pb-4">Аккаунт: не авторизован</div>
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

                <Column :exportable="false" style="max-width: 12rem; min-width:6rem">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.order_type.id == 1" class="flex-col">
                            <div class="mb-6">
                                <Button icon="pi pi-pencil" label="Принять" class="w-full p-button-rounded mr-2 p-button-success" @click="acceptOrder(slotProps.data)"/>
                            </div>
                            <div class="">
                                <Button icon="pi " label="Отклонить" class="w-full p-button-rounded mr-2 p-button-danger" @click="declineOrder(slotProps.data)"/>
                            </div>
                        </div>
                        <div v-else-if="slotProps.data.order_type.id == 2" class="flex-col">
                            <div class="mb-6">
                                <div class="mb-6">
                                    <Button icon="pi" label="Завершить" class="w-full p-button-rounded p-button-warning mr-2" @click="finishOrder(slotProps.data)"/>

                                </div>
                                <div>
                                    <Button icon="pi pi-trash" label="Удалить" class="w-full p-button-rounded p-button-danger mr-2" @click="deleteOrder(slotProps.data)"/>
                                </div>
                            </div>
                        </div>
                        <div v-else class="flex-col">
                            <div class="mb-6">
                                <Button icon="pi pi-trash" label="Удалить" class="w-full p-button-rounded p-button-danger mr-2" @click="deleteOrder(slotProps.data)"/>
                            </div>
                        </div>

                    </template>
                </Column>
                <template #footer> В сумме {{ orders ? orders.length : 0 }} заказов. </template>
            </DataTable>

            <DataTable v-else :value="orders">
                <Column field="code" header="Инфо">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="name" header="Статус заказа">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
                <Column field="name" header="">
                    <template #body>
                        <Skeleton></Skeleton>
                    </template>
                </Column>
            </DataTable>
        </template>
    </AdminPageWrapper>
</template>

<script setup>
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import InputNumber from 'primevue/inputnumber';
import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import OrderService from '../../../../services/OrderService';
import OrderTypeService from "../../../../services/OrderTypeService";
import ServiceService from "../../../../services/ServiceService";
import VueDatePicker from '@vuepic/vue-datepicker';
import Calendar from "primevue/calendar";
import Skeleton from "primevue/skeleton";
import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import OrderQuery from "../../../../services/Query/OrderQuery";
import * as yup from "yup";
import { Form, Field, ErrorMessage} from 'vee-validate';

const schema = yup.object().shape({
    name: yup.string().required(()=>'Имя - обязательное поле'),
    address: yup.string().required(()=>'Адрес - обязательное поле'),
    resource:  yup.number().required(()=>'Категория муосра - обязательное поле'),
    service:  yup.number().required(()=>'Услуга - обязательное поле'),
    order_at:  yup.string().required(()=>'Дата - обязательное поле'),
    tel_number: yup.string().required(() => "Номер телефона - обязательное поле"),
});

const services = computed(()=>store.getters['serviceModule/services']);

const orderService = new OrderService();
const orderTypeService = new OrderTypeService();
const orderQuery = new OrderQuery();
const loaded = ref(false)

const serviceService = new ServiceService();


const toast = useToast();
const confirm = useConfirm();
const store = useStore();

//refs
const orderType = ref({'id': null, 'title':'Выберите cтатус заказа'});
const serviceType = ref({'id': null, 'title':  'Выберите тип услуги'});
const orderAt = ref(null);

//uses

//refs


//computed
const activeOrder = computed(()=>store.getters['orderModule/activeOrder']);
const orders = computed(()=>store.getters['orderModule/orders']);
const orderTypes = computed(()=>store.getters['orderModule/order_types']);



//watches
watch(orderType, async ()=>{
    await loadOrderParams();

})
watch(serviceType, async ()=>{
    await loadOrderParams();

})
watch(orderAt, async ()=>{
    console.log(orderAt.value);
    await loadOrderParams();

})

//methods
const setActiveOrder = (data)=>{
    store.dispatch('orderModule/setActiveOrder', data);
}



const fillData = async () =>{
    await orderService.getOrders(orderQuery).then(data => {
        store.dispatch('orderModule/fillOrders', data.data);
    })
    await orderTypeService.getOrderTypes().then(data => {
        store.dispatch('orderModule/fillOrderTypes', data.data);
    })

    loaded.value = true;

};

const clearActiveOrder = ()=>{
    store.dispatch('orderModule/clearActiveOrder');
}

const findDriver = async (datas) =>{
    setActiveOrder(datas);
    if(activeOrder.value.auto!=null){
        await orderService.findDriver(activeOrder.value.id).then(data => {
            console.log(data.data)
            findOrder(activeOrder.value.id);
        })
    }
    else {
         toast.add({
            severity:'warn',
            summary: 'Осторожно',
            detail:'Вам сразу необходимо подобрать машину',
            life: 3000
        });
    }



}

const findCar = async (datas) =>{
    setActiveOrder(datas);
    await orderService.findCar(activeOrder.value.id).then(data => {
        findOrder(activeOrder.value.id);

    })
    .catch((error) => {
        toast.add({
            severity:'warn',
            summary: 'Не найдено',
            detail:'Видимо все машины заняты на данный момент',
            life: 3000
        });
    });
}

const findOrder = async (id)=>{

    await orderService.getOrder(id).then(data => {
        console.log(data.data)
        store.dispatch('orderModule/updateOrder', {id: id, data: data.data});
    })
}

//crud
const onChangePrice = async (data) => {
    setActiveOrder(data);
    console.log(activeOrder.value);
    activeOrder.value.total_price = activeOrder.value.service.price_one_unit * activeOrder.value.weight;
    console.log(activeOrder.value);

}


const loadOrderParams = async (reset = false) =>{

    loaded.value = false;
    if(reset === false){
        if (serviceType.value.id !== null) {
            orderQuery.addFilter(orderQuery.SERVICE_FILTER, serviceType.value.id);
        }
        else {
            orderQuery.removeFilter(orderQuery.SERVICE_FILTER)

        }
        if (orderType.value.id !== null) {
            orderQuery.addFilter(orderQuery.ORDER_TYPE_FILTER, orderType.value.id);
        }
        else {
            orderQuery.removeFilter(orderQuery.ORDER_TYPE_FILTER)
        }
        if (orderAt.value !== null) {
            orderQuery.addFilter(orderQuery.DATE_FILTER, orderAt.value);
        }
        else {
            orderQuery.removeFilter(orderQuery.DATE_FILTER)
        }
    }
    else {
        orderQuery.deleteParams();
    }
    await fillData();

}

const resetButton = async () =>{
    await loadOrderParams(true);
    serviceType.value = {'id': null, 'title':'Выберите cтатус заказа'};
    orderType.value = {'id': null, 'title':  'Выберите тип услуги'};
    orderAt.value = null;

}

const updateOrder = async (data)=>{
    setActiveOrder(data);
    await confirm.require({
        message:`Вы точно хотите обновить данные заказа?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await toast.add({
                severity:'success',
                summary: 'Успешно изменено!',
                detail:'',
                life: 3000
            })
            // await serviceService.deleteService(id);
            await orderService.updateOrder(activeOrder.value.id, {
                driver_id : activeOrder.value.driver !=null ? activeOrder.value.driver.id : null,
                user_id : activeOrder.value.user !=null ? activeOrder.value.user.id : null,
                auto_id : activeOrder.value.auto !=null ? activeOrder.value.auto.id : null,
                order_types_id : activeOrder.value.order_type != null ? activeOrder.value.order_type.id : null,
                resource_id : activeOrder.value.resource != null ? activeOrder.value.resource.id : null,
                service_id : activeOrder.value.service !=null ? activeOrder.value.service.id : null,
                tel_number : activeOrder.value.tel_number,
                name :  activeOrder.value.name,
                address : activeOrder.value.address,
                weight :  activeOrder.value.weight,
                total_price : activeOrder.value.total_price,
                order_at : activeOrder.value.order_at,
                notice : activeOrder.value.notice,
            }).then(data => {
                findOrder(activeOrder.value.id);
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

const acceptOrder = async (data) =>{
    setActiveOrder(data);

    if(activeOrder.value.auto!=null && activeOrder.value.driver!=null){
        await confirm.require({
            message:`Вы точно хотите принять заказ?`,
            header: 'Подтверждение',
            icon: 'pi pi-exclamation-triangle',
            accept: async () => {
                // await serviceService.deleteService(id);
                await toast.add({
                    severity:'success',
                    summary: 'Успешно принято!',
                    detail:'',
                    life: 3000
                })
                await orderService.acceptOrder(activeOrder.value.id).then(data => {
                }).then(data => {
                    findOrder(activeOrder.value.id);
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
    else {
        await toast.add({
            severity:'warn',
            summary: 'Внимание',
            detail:'Не все данные были корректно заполнены или не подобран персонал',
            life: 3000
        })
    }


}

const finishOrder = async (data) =>{
    setActiveOrder(data);

    await confirm.require({
        message:`Вы точно хотите завершить заказ?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            // await serviceService.deleteService(id);
            await toast.add({
                severity:'success',
                summary: 'Успешно завершено!',
                detail:'',
                life: 3000
            })
            await orderService.finishOrder(activeOrder.value.id).then(data => {
            }).then(data => {
                findOrder(activeOrder.value.id);
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

const declineOrder = async (data) =>{
    setActiveOrder(data);

    await confirm.require({
        message:`Вы точно хотите отклонить заказ, он будет удален?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await toast.add({
                severity:'success',
                summary: 'Успешно отклонено!',
                detail:'',
                life: 3000
            })
            // await serviceService.deleteService(id);
            await orderService.acceptOrder(activeOrder.value.id).then(data => {
            }).then(data => {
                findOrder(activeOrder.value.id);
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

const deleteOrder = async (data)=>{
    setActiveOrder(data);

    await confirm.require({
        message:`Вы точно хотите удалить заказ?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            // await serviceService.deleteService(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:' успешно удалена!',
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
onMounted(async () =>{
    await fillData();
    await serviceService.getServices().then(data => {
        let newServices = data.data.map( x => {
            return {
                id: x.id,
                title: x.title,
                resources: x.resources,
                price_one_unit: x.price_one_unit,
                service_type:  x.service_type,
            }
        })
        store.dispatch('serviceModule/fillServices', newServices);
    })

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
