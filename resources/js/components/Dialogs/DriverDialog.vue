<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Водитель-Грузчик</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-3 field">
                <h2>Водитель</h2>
                <Upload placeholder="dsadas" :source="activeDriver.img" v-model="file"/>
            </div>

            <div class="mb-3 field">
                <h2>Имя</h2>
                <InputText class="w-full" v-model="activeDriver.name"></InputText>
                <ValidationComponent  name="name" v-model="activeDriver.name"></ValidationComponent>

            </div>
            <div class="mb-3 field">
                <h2>Фамилия</h2>
                <InputText class="w-full" v-model="activeDriver.first_name"></InputText>
                <ValidationComponent  name="service" v-model="activeAuto.service.id"></ValidationComponent>

            </div>
            <div class="mb-3 field">
                <h2>Отчество </h2>
                <InputText class="w-full" v-model="activeDriver.patronymic"></InputText>
                <ValidationComponent  name="service" v-model="activeAuto.service.id"></ValidationComponent>

            </div>
            <div class="flex flex-wrap">
                <div class="mr-3 field">
                    <h2>Телефон</h2>
                    <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="activeDriver.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                    <ValidationComponent  name="service" v-model="activeAuto.service.id"></ValidationComponent>

                </div>
                <div class="mb-3 field">
                    <h2>Категория</h2>
                    <MultiSelect v-model="activeDriver.categories" :options="categories"   optionLabel="title" placeholder="Выберите категории" :filter="true" class="multiselect-custom md:w-20rem w-full"
                                 emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов"></MultiSelect>
                </div>
            </div>
        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeDriver.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteDriver"/>
                </div>
                <div>
                    <Button label="Отмена" icon="pi pi-times" class="p-button-text" @click="handleClose"/>
                    <Button label="Сохранить" icon="pi pi-check" autofocus @click="acceptChanges"/>
                </div>
            </div>
        </template>
    </Dialog>
</template>

<script setup>
import {computed, ref, watch} from "vue";
import {useStore} from "vuex";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

import DriverService from "../../services/DriverService";
import AutoCategoryService from "../../services/AutoCategoryService";
import { Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';

//VALIDATION SCHEMA
const schema = yup.object().shape({
    name: yup.string().required(()=>'Имя - обязательное поле'),
    first_name: yup.string().required(()=>'Фамилия - обязательное поле'),
    patronymic:  yup.string().required(()=>'Отчество - обязательное поле'),
    tel_numbers: yup.string().required(() => "Номер телефона - обязательное поле"),
});
const error = ref(false)


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs
const file = ref(null)

const driverService = new DriverService();

//computed
const activeDriver = computed(()=>store.getters['driverModule/activeDriver']);

const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);

//methods

const handleClose = () => {
    file.value = null;
    store.dispatch('driverModule/clearActiveDriver');
    emit('close');
}

const acceptChanges = async () => {
    const data = new FormData()
    data.append("img", file.value);
    data.append('name',  activeDriver.value.name);
    data.append('first_name',  activeDriver.value.first_name);
    data.append('patronymic',  activeDriver.value.patronymic);
    data.append('tel_number',  activeDriver.value.tel_number);


    let categoriesData = [];
    if(activeDriver.value.categories){
        categoriesData = activeDriver.value.categories.map(elem => elem.id);
        data.append('categories', JSON.stringify(categoriesData));
    }
    else {
        data.append('categories', null);
    }
    if(activeDriver.value.id == null){

        await driverService.createDriver(data);

        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Водитель успешно добавлен!',
            life: 3000
        })
    }
    else {

        await driverService.updateDriver(activeDriver.value.id, data);

        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные водителя были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteDriver = async ()=>{
    let id = activeDriver.value.id;
    await confirm.require({
        message:`Вы точно хотите удалить водителя №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await driverService.deleteDriver(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Водитель успешно удален!',
                life: 3000
            })
            handleClose();
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


</script>

<style scoped>

</style>
