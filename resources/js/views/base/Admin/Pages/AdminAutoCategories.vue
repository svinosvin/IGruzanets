<template>
    <AdminPageWrapper headerPage="Водительские Категории (Памятка)">
        <template v-slot:header>
            <Toolbar class="mb-4 flex flex-wrap">
                <template #end>
                </template>
            </Toolbar>
        </template>
        <template v-slot:main>
            <DataTable :value="categories" v-model:selection="activeCategory" dataKey="id"  :resizableColumns="true" columnResizeMode="expand" showGridlines responsiveLayout="scroll"
                      :autoLayot="true" @row-dblclick="dblclickHandler"
             class="p-datatable-sm">
                <template #header>
                </template>
                <Column field="title" header="Название" >
                    <template #body="slotProps">
                      <div class="text-2xl">
                          {{slotProps.data.title}}
                      </div>
                    </template>
                </Column>
                <Column field="description" header="Описание категории"></Column>
            </DataTable>
        </template>
    </AdminPageWrapper>


<!--    <DriverDialog v-model:visible="openDialog" @close="handleCloseDialog"></DriverDialog>-->
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
const categoriesService = new AutoCategoryService();
//uses

//refs
const openDialog = ref(false);

const filter = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'categoriesString': {value: null, matchMode: FilterMatchMode.CONTAINS},
})


//computed
const categories = computed(()=>store.getters['autoCategoryModule/autoCategories']);
const activeCategory = computed(()=>store.getters['autoCategoryModule/activeCategory'])

//methods


const fillCategories = async () =>{
    await categoriesService.getAutoCategories().then(data => {
        store.dispatch('autoCategoryModule/fillCategories', data.data);
    })
}



const clearActiveCategory= ()=>{
    store.dispatch('autoCategoryModule/clearActiveCategory');
}

//handlers
const handleOpenDialog = () =>{
    clearActiveCategory()
    openDialog.value = true;

}

const handleCloseDialog = () => {
    clearActiveCategory()
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
    fillCategories()
})

//crud
const deleteDriver = async (id)=>{
    await confirm.require({
    message:`Вы точно хотите удалить категорию №${id}?`,
    header: 'Подтверждение',
    icon: 'pi pi-exclamation-triangle',
    accept: async () => {
        await categoriesService.deleteAutoCategory(id)
        await toast.add({
            severity:'success',
            summary: 'Удалено!',
            detail:'Категория успешно удалена!',
            life: 3000
        })
        await fillCategories();
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
    fillCategories();

})

onUnmounted(()=>{
    store.dispatch('driverModule/clearStore');
})


</script>

<style scoped>

</style>
