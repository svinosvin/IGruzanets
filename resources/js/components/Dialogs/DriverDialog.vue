<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Водитель-Грузчик</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2>Имя</h2>
                <InputText class="w-full" v-model="activeDriver.name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Фамилия</h2>
                <InputText class="w-full" v-model="activeDriver.first_name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Отчество </h2>
                <InputText class="w-full" v-model="activeDriver.patronymic"></InputText>
            </div>

            <div class="mb-6">
                <h2>Телефон</h2>
                <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="activeDriver.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
            </div>
            <div class="mb-6">
                <h2>Категория</h2>
                <MultiSelect v-model="activeDriver.categories" :options="categories"   optionLabel="title" placeholder="Выберите категории" :filter="true" class="multiselect-custom w-full"
                 display="chip"  emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов"></MultiSelect>
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


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs

const driverService = new DriverService();

//computed
const activeDriver = computed(()=>store.getters['driverModule/activeDriver']);

const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);

//methods

const handleClose = () => {

    store.dispatch('driverModule/clearActiveDriver');
    emit('close');
}

const acceptChanges = async () => {

    if(activeDriver.value.id == null){

        await driverService.createDriver({
            name: activeDriver.value.name,
            first_name: activeDriver.value.first_name,
            patronymic: activeDriver.value.patronymic,
            tel_number: activeDriver.value.tel_number,
            categories : activeDriver.value.categories.map(elem => elem.id)});

        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Водитель успешно добавлен!',
            life: 3000
        })
    }
    else {

        await driverService.updateDriver(activeDriver.value.id,{

            name: activeDriver.value.name,
            first_name: activeDriver.value.first_name,
            patronymic: activeDriver.value.patronymic,
            tel_number: activeDriver.value.tel_number,
            categories : activeDriver.value.categories.map(elem => elem.id)});

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
