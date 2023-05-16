<template>
    <AdminPageWrapper headerPage="Услуги">
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
                       :value="services" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="5"
                       showGridlines
                       scrollable
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                       :rowsPerPageOptions="[5,10]"
                       @row-dblclick="dblclickHandler"
            >
                <template #header>
                    <span class="text-3xl">Услуги</span>
                </template>

                <Column header="Изображение" style="max-width:8rem;">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.img!=null">
                            <img :src="`${slotProps.data.img}`" :alt="slotProps.data.img" class="w-24 h-24  mx-auto" />
                        </div>
                        <div v-else class="text-center">
                            <img src="../../../../../images/admin/empty.png" alt="Нет картинки" class="w-24 h-24  mx-auto" />
                            <div class="font-bold">No image</div>
                        </div>
                    </template>
                </Column>
                <Column field="title" header="Название" style="max-width:8rem" :sortable="true"></Column>
                <Column field="description" header="Описание" style="min-width:23rem"></Column>
                <Column field="Задействуются ресурсы" header="Задействуются ресурсы" style="min-width:15rem">
                    <template #body="slotProps">
                        <div class="font-bold">
                            <ol>
                                <li class="resources pb-2.5" v-for="resource in slotProps.data.resources">
                                    {{resource.title}};
                                    <ul>
                                        <li class="font-light sub_resources" v-for="sub_resource in resource.sub_resources">
                                            {{sub_resource.title}}
                                        </li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </template>
                </Column>
                <Column field="price_one_unit" style="max-width: 6rem" header="Цена за услугу(1кг.)">
                    <template #body="slotProps">
                        <div class="text-center">
                            {{slotProps.data.price_one_unit}} руб.
                        </div>
                    </template>
                </Column>
                <Column header="Тип" :sortable="true" style="max-width: 6rem">
                    <template #body="slotProps">
                        <Tag :value="slotProps.data.service_type.title" :severity="getType(slotProps.data)" />
                    </template>
                </Column>
                <Column :exportable="false" style="min-width:8rem; max-width: 8rem">
                    <template #body="slotProps">
                        <div class="mr-2">
                            <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                        </div>
                        <div>
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteService(slotProps.data.id)"/>
                        </div>
                    </template>
                </Column>
                <template #footer> В сумме {{ services ? services.length : 0 }} услуг. </template>
            </DataTable>

        </template>
    </AdminPageWrapper>
    <ServiceDialog @close="handleCloseDialog" v-model:visible="openDialog"></ServiceDialog>
</template>

<script setup>

import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import ServiceService from '../../../../services/ServiceService';
import ResourceService from '../../../../services/ResourceService';
import ServiceTypeService from '../../../../services/ServiceTypeService';

import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import ServiceDialog from '../../../../components/Dialogs/ServiceDialog.vue';

import Tag from "primevue/tag";

const serviceService = new ServiceService();
const resourceService = new ResourceService();
const typeService = new ServiceTypeService();

const toast = useToast();
const confirm = useConfirm();

//refs
const store = useStore();
//uses

//refs
const openDialog = ref(false);
//
// const filter = ref({
//     'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
//     'categoriesString': {value: null, matchMode: FilterMatchMode.CONTAINS},
// })


//computed
const activeService = computed(()=>store.getters['serviceModule/activeService']);
const services = computed(()=>store.getters['serviceModule/services']);

const Types = { 0: 'Вывоз', 1: 'Продажа'};

//methods
const getType = (service) => {
    switch (service.service_type.title) {
        case Types['0']:
            return 'success';
        case Types['1']:
            return '';
        default:
            return null;
    }
};

const setActiveService = (data)=>{
    store.dispatch('serviceModule/setActiveService', data);
}

const dblclickHandler = (event) =>{
    setActiveService(event.data);
    openDialog.value = true;
}


const fillServices = async () =>{
    await serviceService.getServices().then(data => {
        store.dispatch('serviceModule/fillServices', data.data);
    })
    await typeService.getServiceTypes().then(data => {
        store.dispatch('serviceModule/fillServiceTypes', data.data);
    })
    console.log(services.value);
};

const fillResources = async () =>{
    await resourceService.getSmallResources().then(data => {
        store.dispatch('resourceModule/fillResources', data.data);
    })
}

const clearActiveService = ()=>{
    store.dispatch('serviceModule/clearActiveService');
}


//handlers
const handleOpenDialog = () =>{
    clearActiveService();
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveService();
    openDialog.value = false;

}

const handleEditDialog = (data) => {
    store.dispatch('serviceModule/setActiveService', data)
    openDialog.value = true;
}


watch(openDialog, function (ov, nv) {
    fillResources()
    fillServices();
})

//crud
const deleteService = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить Услугу №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await serviceService.deleteService(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Услуга успешно удалена!',
                life: 3000
            })
            await fillServices();
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
    fillServices();
    fillResources();
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
</style>
