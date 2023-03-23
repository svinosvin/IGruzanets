<template>
    <AdminPageWrapper headerPage="Водители">
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
            <DataTable :value="drivers" v-model:selection="activeDriver" dataKey="id"  :resizableColumns="true" columnResizeMode="expand" showGridlines responsiveLayout="scroll"
                       :paginator="true" v-model:filters="filter" filterDisplay="row" :autoLayot="true" @row-dblclick="dblclickHandler" :rows="5"
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                       :rowsPerPageOptions="[5,10,25]">
                <template #header>

                    <span class="p-input-icon-right">
                        <InputText class="m-1" v-model="filter['global'].value" placeholder="Поиск..." />
                        <i class="pi pi-search" />
            </span>
                </template>
                <Column field="name" header="Имя"  :sortable="true"></Column>
                <Column field="first_name" header="Фамилия" :sortable="true"></Column>
                <Column field="patronymic" header="Отчество" :sortable="true"></Column>
                <Column field="tel_number" header="Номер телефона" :sortable="true"></Column>
                <Column field="categoriesString" header="Категории прав" filterField="categoriesString" :sortable="true" :showFilterMatchModes="true">
                    <template #filter="{filterModel,filterCallback}">
                        <!--                        <MultiSelect v-model="filter['categories'].value" :options="categories" optionLabel="title" placeholder="Выберите категории" :filter="true" class="multiselect-custom"-->
                        <!--                                     emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов">-->
                        <!--                        </MultiSelect>-->
                        <InputText type="text" v-model="filter['categoriesString'].value" class="p-column-filter" :placeholder="`Search by name - `"/>
                    </template>
                </Column>
                <Column :exportable="false" style="min-width:8rem">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                        <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteDriver(slotProps.data.id)"/>
                    </template>
                </Column>
            </DataTable>
        </template>
    </AdminPageWrapper>


    <DriverDialog v-model:visible="openDialog" @close="handleCloseDialog"></DriverDialog>
</template>

<script setup>
import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import DriverService from '../../../../services/DriverService';
import AutoCategoryService from "../../../../services/AutoCategoryService";
import { useStore } from 'vuex';
import DriverDialog from '../../../../components/Dialogs/DriverDialog.vue';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';

const toast = useToast();
const confirm = useConfirm();

//refs
const store = useStore();
const driverService = new DriverService();
const categoriesService = new AutoCategoryService();
//uses

//refs
const openDialog = ref(false);

const filter = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'categoriesString': {value: null, matchMode: FilterMatchMode.CONTAINS},
})


//computed
const activeDriver = computed(()=>store.getters['driverModule/activeDriver']);
const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);

const drivers = computed(()=>store.getters['driverModule/drivers']);

//methods

const fillDrivers = async () =>{
      await driverService.getDrivers().then(data=>{
          store.dispatch('driverModule/fillDrivers', data.data);
      })
};
const fillCategories = async () =>{
    await categoriesService.getAutoCategories().then(data => {
        store.dispatch('autoCategoryModule/fillCategories', data.data);
    })
}



const clearActiveDriver = ()=>{
    store.dispatch('driverModule/clearActiveDriver');
}

//handlers
const handleOpenDialog = () =>{
    clearActiveDriver();
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveDriver();
    openDialog.value = false;

}

const handleEditDialog = (data) => {
    store.dispatch('driverModule/setActiveDriver', data)
    openDialog.value = true;
}

const dblclickHandler = (event) =>{

    store.dispatch('driverModule/setActiveDriver', event.data);
    openDialog.value = true;
};

watch(openDialog, function (ov, nv) {
    fillDrivers();
})

//crud
const deleteDriver = async (id)=>{
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
        await fillDrivers();
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
    fillDrivers();
    fillCategories();

})

onUnmounted(()=>{
    store.dispatch('driverModule/clearStore');
})


</script>

<style scoped>

</style>
