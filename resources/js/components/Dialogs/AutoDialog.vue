<template>
    <Dialog @hide="handleClose"  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Грузовики и Машины</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2>Картинка машины</h2>
                <Upload placeholder="dsadas" :source="activeAuto.img" v-model="file"/>
            </div>
            <div class="mb-6">
                <h2>Марка машины</h2>
                <InputText class="w-full" v-model="activeAuto.mark"></InputText>
            </div>
            <div class="mb-6">
                <h2>Описание</h2>
                <Textarea v-model="activeAuto.description" class="w-full"  :autoResize="true" rows="2" cols="50" />
            </div>
            <div class="mb-6 flex">
                <div class="mr-7">
                    <h2>Грузоподъемность в (т.)</h2>
                    <InputNumber v-model="activeAuto.max_weight" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="0.25" :min="0.5" :max="7" />
                </div>
                <div>
                    <h2>Номер автомобиля</h2>
                    <InputMask  v-model="activeAuto.car_numbers" mask="9999 aa-9" placeholder="3333 AI-7" />
                </div>
            </div>
            <div >
                <h2>Какая водительская категория подходит</h2>
                <Dropdown v-model="activeAuto.auto_category" :options="[{'id':null,'title':'Выберите водительскую категорию',}, ...categories]"
                          optionLabel="title" class="w-full"  placeholder="Выберите водительскую категорию" :filter="true" filterPlaceholder="Найти категорию">
                </Dropdown>

            </div>
        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeAuto.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteAuto"/>
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

import AutoService from "../../services/AutoService";
import AutoCategoryService from "../../services/AutoCategoryService";

import InputNumber from 'primevue/inputnumber';



const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs
const autoService = new AutoService();

//computed
const activeAuto = computed(()=>store.getters['autoModule/activeAuto']);
const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);
const file = ref(null)
//methods

const handleClose = () => {

    file.value = null;
    store.dispatch('autoModule/clearActiveAuto');
    emit('close');
}


const test = () =>
{
    console.log(categories);
    console.log(file.value);
}
const acceptChanges = async () => {

    const data = new FormData()
    data.append("img", file.value);
    data.append('mark',  activeAuto.value.mark);
    data.append('description',  activeAuto.value.description);
    data.append('max_weight',  activeAuto.value.max_weight);
    data.append('car_numbers',  activeAuto.value.car_numbers ?? '');

    if(activeAuto.value.auto_category){
        data.append('auto_category', activeAuto.value.auto_category.id);
    }
    else {
        data.append('auto_category', null);
    }


    if(activeAuto.value.id == null){

        await autoService.createAuto(data);

        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Авто успешно добавлено!',
            life: 3000
        })
    }
    else {

        await autoService.updateAuto(activeAuto.value.id, data);
        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные водителя были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteAuto = async ()=>{
    let id = activeAuto.value.id;
    await confirm.require({
        message:`Вы точно хотите удалить водителя №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await autoService.deleteAuto(id)
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Авто успешно удалено!',
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
