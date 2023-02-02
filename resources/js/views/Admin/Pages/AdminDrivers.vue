<template>
    <Toolbar class="mb-4">
        <template #start>
            <Button label="New" icon="pi pi-plus" class="p-button-success mr-2" @click="createDriver" />
            <Button label="Delete" icon="pi pi-trash" class="p-button-danger"  />
        </template>
        <template #end>
            <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" chooseLabel="Import" class="mr-2 inline-block" />
            <Button label="Export" icon="pi pi-upload" class="p-button-help"/>
        </template>
    </Toolbar>
    <DataTable :value="drivers" v-model:selection="activeDriver" dataKey="id"    :resizableColumns="true" columnResizeMode="expand" showGridlines responsiveLayout="scroll"
               :paginator="true" :autoLayot="true"  :rows="5" paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]">
        <template #header>

                Drivers
        </template>
            <Column field="id" header="ID"></Column>
            <Column field="name" header="Имя" :sortable="true"></Column>
            <Column field="first_name" header="Фамилия" :sortable="true"></Column>
            <Column field="patronymic" header="Отчество" :sortable="true"></Column>
            <Column field="tel_number" header="Номер телефона" :sortable="true"></Column>
            <Column field="categories" header="Категории прав" :sortable="true">
                <template #body="slotProps">
                    <span v-for="category in slotProps.data.categories">
                        {{category.title}};
                    </span>
                </template>
            </Column>
            <Column :exportable="false" style="min-width:8rem">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" class="p-button-rounded mr-2 p-button-success" @click="updateDriver(slotProps.data)"/>
                    <Button icon="pi pi-trash" class="p-button-rounded p-button-warning"  />
                </template>
            </Column>
    </DataTable>

    <Dialog v-model:visible="createDialog"  :style="{width: '75vw'}">
        <template #header>
            <h3>Header</h3>
        </template>
        <div class="flex-column justify-center">
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div><div>
            <input type="text" name="dsa" placeholder="dsadasd">
        </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div><div>
            <input type="text" name="dsa" placeholder="dsadasd">
        </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div><div>
            <input type="text" name="dsa" placeholder="dsadasd">
        </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
            <div>
                <input type="text" name="dsa" placeholder="dsadasd">
            </div>
        </div>
        <template #footer>
            <Button label="No" icon="pi pi-times" class="p-button-text"/>
            <Button label="Yes" icon="pi pi-check" autofocus />
        </template>
    </Dialog>
</template>

<script setup>
import DriverService from '../../../services/DriverService';
import { useStore } from 'vuex';
import {computed, onMounted, onUnmounted, ref} from "vue";
const store = useStore();
const driverService = new DriverService();
//uses

//refs
const createDialog = ref(false);


//computed
const activeDriver = computed(()=>store.getters['driverModule/activeDriver']);
const drivers = computed(()=>store.getters['driverModule/drivers']);


//methods
const fillDrivers = () =>{
      driverService.getDrivers().then(data=>{
          store.dispatch('driverModule/fillDrivers', data.data);
      })
};
const setActiveDriver = (driver)=>{
    store.dispatch('driverModule/setActiveDriver', driver);
};

const clearActiveDriver = ()=>{
    store.dispatch('driverModule/clearActiveDriver');
}

const clearDriversStore = ()=>{
    store.dispatch('driverModule/clearStore');
}

//crud
const createDriver = ()=>{
    console.log('dsadas');
    createDialog.value = true;
}

const updateDriver = (driver)=>{
    setActiveDriver(driver);
    console.log(activeDriver);
}
const deleteDriver = ()=>{

}


//hooks
onMounted(() =>{
    fillDrivers();
})
onUnmounted(()=>{
    store.dispatch('driverModule/clearStore');
})




</script>

<style scoped>

</style>
