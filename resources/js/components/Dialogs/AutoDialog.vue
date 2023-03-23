<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Водитель-Грузчик</h3>
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
                <InputText class="w-full" v-model="activeAuto.first_name"></InputText>
            </div>
            <div class="mb-6">
                <h2>Максимальное кол-во</h2>
                <InputText class="w-full" v-model="activeAuto.patronymic"></InputText>
            </div>
            <div class="mb-6">
                <h2>Какая водительская категория подходит</h2>

            </div>
        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeAuto.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteDriver"/>
                </div>
                <div>
                    <Button label="Отмена" icon="pi pi-times" class="p-button-text" @click="handleClose"/>
                    <Button label="Сохранить" icon="pi pi-check" autofocus @click="test"/>
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


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
//refs
const autoService = new AutoService();

//computed
const activeAuto = computed(()=>store.getters['autoModule/activeAuto']);
const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);
const file = ref({})
//methods

const handleClose = () => {

    store.dispatch('autoModule/clearActiveAuto');
    emit('close');
}

const test = () =>
{
    console.log(file.value);
}
const acceptChanges = async () => {

    if(activeAuto.value.id == null){

        await autoService.createAuto({
            mark:  activeAuto.value.mark,
            description: activeAuto.value.description,
            img: activeAuto.value.img,
            max_weight: activeAuto.value.max_weight,
            auto_category: activeAuto.value.auto_category.id,
        });

        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Авто успешно добавлено!',
            life: 3000
        })
    }
    else {

        await autoService.updateAuto(activeAuto.value.id,{
            mark:  activeAuto.value.mark,
            description: activeAuto.value.description,
            img: activeAuto.value.img,
            max_weight: activeAuto.value.max_weight,
            auto_category: activeAuto.value.auto_category.id,
        });

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
