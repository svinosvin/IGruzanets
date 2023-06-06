<template>
    <AdminPageWrapper headerPage="База Пользователей">
        <template v-slot:header>
            <Toolbar class="mb-4 flex flex-wrap">
                <template #start>
<!--                    <Button label="Добавить" icon="pi pi-plus" class="p-button-success mr-5" @click="handleOpenDialog" />-->
                </template>
                <template #end>
                </template>
            </Toolbar>
        </template>
        <template v-slot:main>
            <DataTable style=""  :class="`p-datatable-sm`"
                       :value="users" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="5"
                       showGridlines
                       scrollable
                       v-model:filters="filter"
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                       :rowsPerPageOptions="[5,10]"
                       @row-dblclick="dblclickHandler"

            >
                <template #header>
                  <span class="p-input-icon-right">
                        <InputText class="m-1" v-model="filter['global'].value" placeholder="Поиск..." />
                        <i class="pi pi-search" />
                   </span>
                </template>
                <Column field="name" header="Имя"  class="font-bold" :sortable="true"></Column>
                <Column field="first_name" header="Фамилия"></Column>
                <Column field="patronymic" header="Отчество"></Column>
                <Column field="email" header="Почта"></Column>
                <Column field="tel_number" header="Номер телефона"></Column>
                <Column field="company.title" class="font-bold" :sortable="true" header="Компания"></Column>

                <Column :exportable="false" style="min-width:6rem">
                    <template #body="slotProps">
                        <div class="mr-2">
                            <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                        </div>
                        <div>
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteUser(slotProps.data.id)"/>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </AdminPageWrapper>

    <UserDialog @close="handleCloseDialog" v-model:visible="openDialog"></UserDialog>
</template>

<script setup>

import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import UserService from '../../../../services/UserService';
import CompanyService from '../../../../services/CompanyService';

import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import UserDialog from '../../../../components/Dialogs/UserDialog.vue';

const userService = new UserService();
const companyService = new CompanyService();

const toast = useToast();
const confirm = useConfirm();

//refs
const store = useStore();
//uses

//refs
const openDialog = ref(false);
//
const filter = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
})


//computed
const activeUser = computed(()=>store.getters['userModule/activeUser']);
const users = computed(()=>store.getters['userModule/users']);


//methods

const setActiveUser = (data)=>{
    store.dispatch('userModule/setActiveUser', data);
}

const dblclickHandler = (event) =>{
    setActiveUser(event.data);
    openDialog.value = true;
}


const fillUsers = async () =>{
    await userService.getUsers().then(data => {
        console.log(data.data);
        store.dispatch('userModule/fillUsers', data.data);
    })
};
const fillCompanies = async () =>{
    await companyService.getCompanies().then(data => {
        let newData = data.data.map(obj => {
            return {
                'id': obj.id,
                'title': obj.title
            }
        });
        store.dispatch('companyModule/fillCompanies', newData);

    })
}

const clearActiveUser = ()=>{
    store.dispatch('userModule/clearActiveUser');
}


//handlers
const handleOpenDialog = () =>{
    clearActiveUser();
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveUser();
    openDialog.value = false;

}

const handleEditDialog = (data) => {
    store.dispatch('userModule/setActiveUser', data)
    openDialog.value = true;
}


watch(openDialog, function (ov, nv) {
    fillUsers();
    fillCompanies();
})

//crud
const deleteUser = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить Пользователя №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await userService.deleteUser(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Пользователь успешно удален!',
                life: 3000
            })
            await fillUsers();
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
    fillCompanies();
    fillUsers();
})

onUnmounted(()=>{
    store.dispatch('userModule/clearStore');
    store.dispatch('companyModule/clearStore');
})

</script>

<style scoped>

</style>
