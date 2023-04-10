<template>
 <AdminPageWrapper headerPage="Машины">
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
         <DataTable  :class="`p-datatable-sm`"
             :value="autos" :sortOrder="2"  :paginator="true" :rows="3"
             showGridlines
             paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
             :rowsPerPageOptions="[3,10]"
             @row-dblclick="dblclickHandlerAuto"
         >
             <template #header>
                 <span class="text-3xl">Машины</span>
             </template>
             <Column header="Изображение">
                 <template #body="slotProps">
                     <div v-if="slotProps.data.img!=null">
                         <img :src="`${slotProps.data.img}`" :alt="slotProps.data.img" class="w-32 h-32 rounded-full mx-auto" />
                     </div>
                     <div v-else class="text-center">
                         <img src="../../../../../images/admin/auto.png" alt="Нет картинки" class="w-28 h-28 rounded-full mx-auto" />
                         <div class="font-bold">Нет изображения</div>
                     </div>
                 </template>
             </Column>
             <Column field="mark" header="Марка"></Column>
             <Column field="description" header="Описание"></Column>
             <Column field="max_weight" header="Максимальная масса груза (т.)"></Column>
             <Column field="auto_category.title" header="Требуемая водительская категория"></Column>

             <Column :exportable="false" style="min-width:8rem">
                 <template #body="slotProps">
                     <div class="mb-2">
                         <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleEditDialog(slotProps.data)"/>
                     </div>
                     <div>
                         <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteAuto(slotProps.data.id)"/>
                     </div>
                 </template>
             </Column>
         </DataTable>
     </template>
 </AdminPageWrapper>
    <AutoDialog @close="handleCloseDialog" v-model:visible="openDialog"></AutoDialog>
</template>

<script setup>

import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import AutoService from '../../../../services/AutoService'
import AutoCategoryService from "../../../../services/AutoCategoryService";
import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import AutoDialog from '../../../../components/Dialogs/AutoDialog.vue';


const toast = useToast();
const confirm = useConfirm();

//refs
const store = useStore();
const autoService = new AutoService();
const categoriesService = new AutoCategoryService();
//uses

//refs
const openDialog = ref(false);
//
// const filter = ref({
//     'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
//     'categoriesString': {value: null, matchMode: FilterMatchMode.CONTAINS},
// })


//computed
const activeAuto = computed(()=>store.getters['autoModule/activeAuto']);
const autos = computed(()=>store.getters['autoModule/autos']);


//methods

const setActiveAuto = (data)=>{
    store.dispatch('autoModule/setActiveAuto', data);
}

const dblclickHandlerAuto = (event) =>{
    setActiveAuto(event.data);
    openDialog.value = true;
}


const fillAutos = async () =>{
    await autoService.getAutos().then(data => {
        store.dispatch('autoModule/fillAutos', data.data);
    })
};
const fillCategories = async () =>{
    await categoriesService.getAutoCategories().then(data => {
        store.dispatch('autoCategoryModule/fillCategories', data.data);
    })
}

const clearActiveAuto = ()=>{
    store.dispatch('autoModule/clearActiveAuto');
}


//handlers
const handleOpenDialog = () =>{
    clearActiveAuto();
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveAuto();
    openDialog.value = false;

}

const handleEditDialog = (data) => {
    store.dispatch('autoModule/setActiveAuto', data)
    openDialog.value = true;
}

const dblclickHandler = (event) =>{

    store.dispatch('autoModule/setActiveAuto', event.data)
    openDialog.value = true;
};

watch(openDialog, function (ov, nv) {
    fillAutos();
})

//crud
const deleteAuto = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить Авто №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await autoService.deleteAuto(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Авто успешно удалено!',
                life: 3000
            })
            await fillAutos();
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
    fillAutos();
    fillCategories();
})

onUnmounted(()=>{
    store.dispatch('driverModule/clearStore');
})

</script>

<style scoped>

</style>
