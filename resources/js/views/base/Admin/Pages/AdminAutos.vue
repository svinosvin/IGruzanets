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
         <DataTable style=""  :class="`p-datatable-sm`"
                     :value="autos" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="5"
                     showGridlines
                    scrollable
                     paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                     :rowsPerPageOptions="[5,10]"
                     @row-dblclick="dblclickHandlerAuto"
         >
             <template #header>
                 <span class="text-3xl">Машины</span>
             </template>
             <Column header="Изображение" style="max-width:8rem;">
                 <template #body="slotProps">
                     <div v-if="slotProps.data.img!=null">
                         <img :src="`${slotProps.data.img}`" :alt="slotProps.data.img" class="w-24 h-24 mx-auto" />
                     </div>
                     <div v-else class="text-center">
                         <img src="../../../../../images/admin/auto.png" alt="Нет картинки" class="w-24 h-24  mx-auto" />
                         <div class="font-bold">Нет изображения</div>
                     </div>
                 </template>
             </Column>
             <Column field="mark" header="Марка"  :sortable="true"></Column>
             <Column field="description" header="Описание" ></Column>
             <Column field="car_numbers" header="Номер автомобиля">
                 <template #body="slotProps">
                     <div class="font-bold">
                         {{slotProps.data.car_numbers}}
                     </div>
                 </template>
             </Column>
             <Column field="max_weight" header="Ограничение (тонн.)"  :sortable="true"></Column>
             <Column field="auto_category.title" header="Требуемая водительская категория"  :sortable="true"></Column>

             <Column :exportable="false" style="min-width:6rem">
                 <template #body="slotProps">
                     <div class="mr-2">
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
