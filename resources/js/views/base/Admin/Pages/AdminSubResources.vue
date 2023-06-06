<template>
    <AdminPageWrapper headerPage="Компоненты и Подкомпоненты">
            <template v-slot:header>
                <Toolbar class="mb-4 flex flex-wrap">
                    <template #start>
                        <Button label="Добавить Компонент" icon="pi pi-plus" class="p-button-success mr-5" @click="handleOpenResourceDialog"  />
                    </template>
                    <template #end>
                    </template>
                </Toolbar>
            </template>
            <template v-slot:main>
                <div class="mb-20">
                    <DataTable style="font-size: 90%"
                        :value="resources" :sortOrder="2" :class="`p-datatable-sm`" :paginator="true" :rows="5"
                        showGridlines :autoLayot="true"
                               v-model:filters="filter"
                               paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[5,10]" scrollable  @row-dblclick="dblclickHandlerResource"
                    >

                        <template #header>
                          <span class="p-input-icon-right">
                            <InputText class="m-1" v-model="filter['global'].value" placeholder="Поиск..." />
                            <i class="pi pi-search" />
                         </span>
                        </template>
                        <Column field="title" header="Название" :sortable="true">
                            <template #body="slotProps">
                                <div class="text-xl font-bold text-emerald-600" >
                                    {{slotProps.data.title}}

                                </div>
                            </template>
                        </Column>
                        <Column field="description" header="Описание" style="max-width:40rem"></Column>
                        <Column field="examples" header="Примеры" ></Column>
                        <Column :exportable="false" style="min-width:6rem">
                            <template #body="slotProps">
                                <div class="flex">
                                    <div class="">
                                        <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleResourceEditDialog(slotProps.data.id)"/>
                                    </div>
                                    <div>
                                        <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteResource(slotProps.data.id)"/>
                                    </div>
                                </div>
                            </template>
                        </Column>
                    </DataTable>
                </div>
                <Toolbar class="mb-4 flex flex-wrap">
                    <template #start>

                        <Button label="Добавить подкомпонент" icon="pi pi-plus" class="p-button-success mr-5" @click="handleOpenSubresourceDialog" />
                    </template>
                    <template #end>

                    </template>
                </Toolbar>
                <div class="mb-20">
                    <DataTable style="font-size:85%" :value="subresources" showGridlines  :class="`p-datatable-sm`"
                               rowGroupMode="subheader" :autoLayot="true"
                               sortMode="single"
                               sortField="resource"
                               groupRowsBy="resource.title"
                               :sortOrder="1"
                               scrollable
                               v-model:filters="filter1"

                               @row-dblclick="dblclickHandlerSub"
                               :paginator="true" :rows="10"
                               paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                               :rowsPerPageOptions="[10,15,20]"
                    >
                        <template #header>
                             <span class="p-input-icon-right">
                            <InputText class="m-1" v-model="filter1['global'].value" placeholder="Поиск..." />
                            <i class="pi pi-search" />
                         </span>
                        </template>
                        <Column field="resource.title" header="Resource"></Column>
                        <Column field="title" header="Название">
                            <template #body="slotProps">
                                <div class="text-gray-500 font-bold"  style="font-size: 120%">
                                    {{slotProps.data.title}}
                                </div>
                            </template>
                        </Column>
                        <Column field="description" header="Описание"  style="max-width:40rem" ></Column>
                        <Column field="examples" header="Примеры"></Column>
                        <Column :exportable="false" style="min-width:6rem">
                            <template #body="slotProps">
                                <div class="mr-2">
                                    <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="handleSubresourceEditDialog(slotProps.data)"/>
                                </div>
                                <div>
                                    <Button icon="pi pi-trash" class="p-button-rounded p-button-danger"  @click="deleteSubResource(slotProps.data.id)"/>
                                </div>
                                <!--                deleteDriver(slotProps.data.id)-->
                            </template>
                        </Column>
                        <template #groupheader="slotProps">
                            <div class="font-bold text-xl">
                                <div class="justify-center mb-2 text-emerald-600">{{slotProps.data.resource !=null ? slotProps.data.resource.title : 'Не выбрано'}}</div>

                                <Button v-if="slotProps.data.resource !=null" label="Изменить" icon="pi pi-pencil" class="p-button-warning text-black" @click="handleResourceEditDialog(slotProps.data.resource.id)" />
                            </div>
                        </template>

                    </DataTable>
                </div>
            </template>
    </AdminPageWrapper>

    <SubResourceDialog v-model:visible="openSubResourceDialog" @close="handleSubresourceCloseDialog"/>
    <ResourceDialog v-model:visible="openResourceDialog" @close="handleResourceCloseDialog"/>
</template>

<script setup>
import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import { useStore } from 'vuex';
import SubResourceDialog from '../../../../components/Dialogs/SubResourceDialog.vue';
import ResourceDialog from '../../../../components/Dialogs/ResourceDialog.vue';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import {FilterMatchMode,FilterOperator} from 'primevue/api';

import ResourceService from "../../../../services/ResourceService";
import SubResourceService from "../../../../services/SubResourceService";



const toast = useToast();
const confirm = useConfirm();
const store = useStore();
const resourceService = new ResourceService();
const sresourceService = new SubResourceService()


//uses

//refs
const openSubResourceDialog = ref(false);
const openResourceDialog = ref(false);

const filter = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'resources': {value: null, matchMode: FilterMatchMode.CONTAINS},
})
const filter1 = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
})
//computed
const activeSubResource = computed(()=>store.getters['subresourceModule/activeSubResource']);
const activeResource = computed(()=>store.getters['resourceModule/activeResource'])
const subresources = computed(()=>store.getters['subresourceModule/subResources']);
const resources = computed(()=>store.getters['resourceModule/resources'])
//methods

const fillSubresources = async () =>{
    await sresourceService.getSubResources().then(data=>{
        store.dispatch('subresourceModule/fillSubResources', data.data);
    })
};
const fillResources = async () => {
    await resourceService.getResources().then(data=>{
        store.dispatch('resourceModule/fillResources', data.data)
    })
}

// const fillCategories = async () =>{
//     await categoriesService.getAutoCategories().then(data => {
//         store.dispatch('autoCategoryModule/fillCategories', data.data);
//     })
// }


const clearActiveSubResource = ()=>{
    store.dispatch('subresourceModule/clearActiveSubResource');
}


const setActiveSubResource = (data)=>{
    store.dispatch('subresourceModule/setActiveSubResource', data);
}

const setActiveResource = (data)=>{
    store.dispatch('resourceModule/setActiveResource', data);
}

const clearActiveResource = ()=>{
    store.dispatch('resourceModule/clearActiveResource');
}

//handlers

//SubResourceHandlers
const handleOpenSubresourceDialog = () =>{
    clearActiveSubResource();
    openSubResourceDialog.value = true;

}

const handleSubresourceCloseDialog = () => {
    clearActiveSubResource();
    openSubResourceDialog.value = false;

}

const handleSubresourceEditDialog = (data) => {
    setActiveSubResource(data);
    openSubResourceDialog.value = true;
}
//ResourceHandlers

const handleOpenResourceDialog = () =>{
    clearActiveResource();
    openResourceDialog.value = true;

}

const handleResourceCloseDialog = () => {
    clearActiveResource();
    openResourceDialog.value = false;

}

const handleResourceEditDialog = (id) => {
    resourceService.getResource(id).then(data =>
    {
        setActiveResource(data.data);
    })
     openResourceDialog.value = true;
}

const dblclickHandlerSub = (event) =>{
    setActiveSubResource(event.data);
    openSubResourceDialog.value = true;
};

const dblclickHandlerResource = (event) =>{
    resourceService.getResource(event.data.id).then(data =>
    {
        setActiveResource(data.data);
    })
     openResourceDialog.value = true;
}

//watches
watch(openSubResourceDialog, function (ov, nv) {
    fillSubresources();
    fillResources();
})

watch(openResourceDialog, function (ov,nv){
    clearActiveResource();
    fillResources();
    if(openResourceDialog.value === false){
        fillSubresources()
    }


})








//crud
const deleteSubResource = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить подкомпонент №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await sresourceService.deleteSubResource(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Подкатегория успешно удален!',
                life: 3000
            })
            await fillSubresources();
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

const deleteResource = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить компонент №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await resourceService.deleteResource(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Копмонент успешно удалена!',
                life: 3000
            })
            await fillResources();
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
};

//hooks
onMounted(() =>{
    fillSubresources();
    fillResources();

})

onUnmounted(()=>{
    store.dispatch('subresourceModule/clearStore');
    store.dispatch('resourceModule/clearStore');
})


</script>

<style scoped>

</style>
