<template>
    <Dialog :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Подкатегория</h3>
        </template>
        <Form :validation-schema="schema"  validate-on-mount @submit="acceptChanges">
        <div class="flex-column justify-center">
            <div class="mb-3">
                <h2>Пример выполненых услуг</h2>
                <Upload placeholder="dsadas" :source="activeService.img" v-model="file"/>
            </div>
            <div class="mb-3">
                <h2>Тип оказываемы услуг</h2>

                <Dropdown v-model="activeService.service_type"  :options="[{'id': null, 'title': 'Выберите тип услуги'}, ...serviceTypes]"
                          optionLabel="title" class="w-full"  placeholder="Выберите тип услуги" :filter="true">
                </Dropdown>
                <ValidationComponent v-if="serviceTypes.length>0 && activeService.service_type!=null" name="service_type" v-model="activeService.service_type.id"></ValidationComponent>

            </div>
            <div class="mb-3">
                <h2 class="font-bold">Категория</h2>
                <MultiSelect v-model="activeService.resources"  :options="resources"  optionLabel="title" placeholder="Выберите ресурсы" :filter="true" class="multiselect-custom w-full md:w-20rem"
                             emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов"></MultiSelect>
            </div>
            <div class="mb-3">
                <h2 class="font-bold">Цена в руб.</h2>
                <InputNumber v-model="activeService.price_one_unit" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="0.1" :min="0.1" :max="10000" />

            </div>
            <div class="mb-3">
                <h2 class="font-bold">Название</h2>
                <InputText v-model="activeService.title" class="w-full"></InputText>
                <ValidationComponent name="title" v-model="activeService.title"></ValidationComponent>

            </div>
            <div class="">
                <h2 class="font-bold">Описание</h2>
                <Textarea v-model="activeService.description" class="w-full" :autoResize="true" rows="4" cols="50" />
                <ValidationComponent name="description" v-model="activeService.title"></ValidationComponent>

            </div>
        </div>
        </Form>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeService.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteService"/>
                </div>
                <div>
                    <Button label="Отмена" icon="pi pi-times" class="p-button-text" @click="handleClose"/>
                    <Button label="Сохранить" icon="pi pi-check" class="p-button" autofocus @click="acceptChanges"/>
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
import ResourceService from "../../services/ResourceService";
import ServiceService from "../../services/ServiceService";
import InputNumber from 'primevue/inputnumber';
import { Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';


//VALIDATION SCHEMA
const schema = yup.object().shape({
    title: yup.string().required(()=>'Название услуги - обязательное поле'),
    service_type: yup.string().required(() => "Тип услуги - обязательное поле"),
    description:  yup.string().required(() => "Описание - обязательное поле"),

});
//uses
const toast = useToast();
const confirm = useConfirm();
const store = useStore();
const resourceService = new ResourceService();
const serviceService = new ServiceService();

const emit = defineEmits(['close'])

const file = ref(null)
const type = ref();



//computed
const activeService = computed(()=>store.getters['serviceModule/activeService']);
const resources = computed(()=>store.getters['resourceModule/resources']);
const serviceTypes = computed(()=>store.getters['serviceModule/service_types']);

//methods

const handleClose = () => {
    file.value = null;
    store.dispatch('serviceModule/clearActiveService');
    emit('close');
}

const acceptChanges = async () => {

    const data = new FormData()
    data.append("img", file.value);
    data.append('title',  activeService.value.title);
    data.append('description',  activeService.value.description);
    data.append('price_one_unit',  activeService.value.price_one_unit);
    data.append('service_type',  activeService.value.service_type.id !=null ? activeService.value.service_type.id : 1);

    let resourcesData = [];
    if(activeService.value.resources){
        resourcesData = activeService.value.resources.map(el => el.id);
        console.log(resourcesData);
        data.append('resources', JSON.stringify(resourcesData));
    }
    else {
        data.append('resources', null);
    }
    if(activeService.value.id == null){

        await serviceService.createService(data);


        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Услуга успешно добавлена!',
            life: 3000
        })
    }
    else {

        await serviceService.updateService(activeService.value.id,data);


        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные услуги были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteService = async ()=>{
    let id = activeService.value.id;
    await confirm.require({
        message:`Вы точно хотите удалить подкомпонент №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await serviceService.deleteService(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Услуга успешно удалена!',
                life: 3000
            })
            handleClose()
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
    console.log(serviceTypes.value);
})
</script>

<style scoped>

</style>
