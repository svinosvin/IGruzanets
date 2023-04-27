<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Водитель-Грузчик</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2>Имя</h2>
                <InputText class="w-full" v-model="activeUser.name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Фамилия</h2>
                <InputText class="w-full" v-model="activeUser.first_name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Отчество </h2>
                <InputText class="w-full" v-model="activeUser.patronymic"></InputText>
            </div>
            <div class="mb-6">
                <h2>Email </h2>
                <InputText class="w-full" v-model="activeUser.email"></InputText>
            </div>

            <div class="mb-6">
                <h2>Телефон</h2>
                <InputMask placeholder="8 0XX XХХХХХХ" class="w-full"  v-model="activeUser.tel_number" mask="8 099 9999999" slotChar="8 0XX XХХХХХХ" />
            </div>
            <div class="mb-6">
                <h2>Компания</h2>
                <Dropdown v-model="activeUser.company"  :options="[{'id':null,'title':'Выберите компанию',}, ...companies]"
                          optionLabel="title" class="w-full"  placeholder="Выберите категорию" :filter="true" filterPlaceholder="Найти компанию">
                </Dropdown>
            </div>
        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeUser.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteUser"/>
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

import UserService from "../../services/UserService";


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs

const userService = new UserService();

//computed
const activeUser= computed(()=>store.getters['userModule/activeUser']);

const companies = computed(()=>store.getters['companyModule/companies']);

//methods

const handleClose = () => {

    store.dispatch('userModule/clearActiveUser');
    emit('close');
}

const acceptChanges = async () => {

    if(activeUser.value.id == null){

        await userService.createUser({
            name: activeUser.value.name,
            email: activeUser.value.email,
            first_name: activeUser.value.first_name,
            patronymic: activeUser.value.patronymic,
            tel_number: activeUser.value.tel_number,
            company: activeUser.value.company.id
        });
        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Водитель успешно добавлен!',
            life: 3000
        })
    }
    else {

        await userService.updateUser(activeUser.value.id,{

            email: activeUser.value.email,
            name: activeUser.value.name,
            first_name: activeUser.value.first_name,
            patronymic: activeUser.value.patronymic,
            tel_number: activeUser.value.tel_number,
            company: activeUser.value.company.id });

        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные водителя были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteUser = async ()=>{
    let id = activeUser.value.id;
    await confirm.require({
        message:`Вы точно хотите удалить пользователя №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await userService.deleteUser(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Пользователь успешно удален!',
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
