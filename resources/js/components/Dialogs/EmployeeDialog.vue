<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Сотрудник</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2>Имя</h2>
                <InputText class="w-full" v-model="activeEmployee.name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Фамилия</h2>
                <InputText class="w-full" v-model="activeEmployee.first_name"></InputText>
                <small></small>
            </div>
            <div class="mb-6">
                <h2>Отчество </h2>
                <InputText class="w-full" v-model="activeEmployee.patronymic"></InputText>
                <small></small>
            </div>
            <div class="flex flex-shrink-1 flex-wrap w-full mb-6">
                <div class="mr-6">
                    <h2>Email </h2>
                    <InputText class="w-full" v-model="activeEmployee.email"></InputText>
                    <small></small>
                </div>
                <div>
                    <h2>Телефон</h2>
                    <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="activeEmployee.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
                    <small></small>
                </div>
            </div>
            <div class="flex" v-if="activeEmployee.id==null">
                <div  class="mr-6">
                    <h2>Придумайте Пароль</h2>
                    <Password class="w-full" v-model="activeEmployee.password" toggleMask :feedback="false"></Password>
                </div>
                <small></small>
                <div>
                    <h2>Повторите пароль</h2>
                    <Password class="w-full"  v-model="activeEmployee.password_confirmation" :feedback="false" toggleMask></Password>
                </div>

            </div>
            <div>
                <small class="pt-2 text-red-800" :class="{hidden1: !(activeEmployee.password!='' && activeEmployee.password!=activeEmployee.password_confirmation)}">Пароль не совпадает</small>
            </div>

        </div>

        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeEmployee.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteUser"/>
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

import AdminService from "../../services/AdminService";


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs

const employeeService = new AdminService();

//computed
const activeEmployee= computed(()=>store.getters['employeeModule/activeEmployee']);


//methods

const handleClose = () => {

    store.dispatch('employeeModule/clearActiveEmployee');
    emit('close');
}

const acceptChanges = async () => {

    if(activeEmployee.value.id == null){

        await employeeService.createEmployee({
            name: activeEmployee.value.name,
            email: activeEmployee.value.email,
            first_name: activeEmployee.value.first_name,
            patronymic: activeEmployee.value.patronymic,
            tel_number: activeEmployee.value.tel_number,
            password: activeEmployee.value.password,
            password_confirmation: activeEmployee.value.password_confirmation,

        });
        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Сотрудник успешно добавлен!',
            life: 3000
        })
    }
    else {

        await employeeService.updateEmployee(activeEmployee.value.id, {
            email: activeEmployee.value.email,
            name: activeEmployee.value.name,
            first_name: activeEmployee.value.first_name,
            patronymic: activeEmployee.value.patronymic,
            tel_number: activeEmployee.value.tel_number,
        });
        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные сотрудника были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteUser = async ()=>{
    let id = activeEmployee.value.id;
    await confirm.require({
        message:`Вы точно хотите удалить сотрудника №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await employeeService.deleteEmployee(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Сотрудник успешно удален!',
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

.hidden1{
    visibility:hidden;
}
</style>
