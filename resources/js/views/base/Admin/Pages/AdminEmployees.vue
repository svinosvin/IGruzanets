<template>
    <AdminPageWrapper headerPage="База Сотрудников">
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
                       :value="employees" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="5"
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

                <Column :exportable="false" style="min-width:6rem">
                    <template #body="slotProps">
                        <div class="mr-2">
                            <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                        </div>
                        <div v-if="currentAdmin.id!=slotProps.data.id">
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteUser(slotProps.data.id)"/>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </AdminPageWrapper>

    <EmployeeDialog @close="handleCloseDialog" v-model:visible="openDialog"></EmployeeDialog>
</template>

<script setup>

import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import AdminService from '../../../../services/AdminService';

import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import EmployeeDialog from '../../../../components/Dialogs/EmployeeDialog.vue';
const employeeService = new AdminService();

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
const activeEmployee = computed(()=>store.getters['employeeModule/activeEmployee']);
const employees = computed(()=>store.getters['employeeModule/employees']);
const currentAdmin = computed(()=>store.getters['authAdmin/currentAdmin']);

//methods

const setActiveEmployee = (data)=>{
    store.dispatch('employeeModule/setActiveEmployee', data);
}

const dblclickHandler = (event) =>{
    setActiveEmployee(event.data);
    openDialog.value = true;
}


const fillEmployees = async () =>{
    await employeeService.getEmployees().then(data => {
        console.log(currentAdmin.value);
        // let newData = data.data.filter(obj => obj.id != currentAdmin.value.id)

        store.dispatch('employeeModule/fillEmployees', data.data);
    })
};

const clearActiveEmployee = ()=>{
    store.dispatch('employeeModule/clearActiveEmployee');
}


//handlers
const handleOpenDialog = () =>{
    clearActiveEmployee();
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveEmployee();
    openDialog.value = false;

}

const handleEditDialog = (data) => {
    store.dispatch('employeeModule/setActiveEmployee', data)
    openDialog.value = true;
}


watch(openDialog, function (ov, nv) {
    fillEmployees();
})

//crud
const deleteUser = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить Пользователя №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await employeeService.deleteEmployee(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Услуга успешно удалена!',
                life: 3000
            })
            await fillEmployees();
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
    store.dispatch('authAdmin/getDataAdmin');
    fillEmployees();
})

onUnmounted(()=>{
    store.dispatch('employeeModule/clearStore');
})

</script>

<style scoped>

</style>
