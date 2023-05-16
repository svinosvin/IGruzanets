<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Категория</h3>
        </template>
        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2 class="font-bold">Категория</h2>
                <MultiSelect v-model="activeResource.sub_resources"  :options="subresources"  optionLabel="title" placeholder="Выберите категории" :filter="true" class="multiselect-custom w-full md:w-20rem"
                             emptyFilterMessage="Ничего не найдено" emptyMessage="Нету доступных вариантов"></MultiSelect>
            </div>
            <div class="mb-6">
                <h2 class="font-bold">Название</h2>
                <InputText v-model="activeResource.title" class="w-full"></InputText>
            </div>
            <div class="mb-6">
                <h2 class="font-bold">Описание</h2>
                <Textarea v-model="activeResource.description" class="w-full" :autoResize="true" rows="5" cols="50" />
            </div>
            <div class="mb-6">
                <h2 class="font-bold">Примеры </h2>
                <Textarea v-model="activeResource.examples" class="w-full"  :autoResize="true" rows="5" />
            </div>
        </div>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeResource.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteResource"/>
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
import ResourceService from "../../services/ResourceService";
import SubResourceService from "../../services/SubResourceService";

//uses
const toast = useToast();
const confirm = useConfirm();
const store = useStore();
const resourceService = new ResourceService();
const sresourceService = new SubResourceService()


const emit = defineEmits(['close'])

//computed
const activeResource = computed(()=>store.getters['resourceModule/activeResource']);
const subresources = computed(()=>store.getters['subresourceModule/smallSubResources']);
//methods

const handleClose = () => {

    store.dispatch('resourceModule/clearActiveResource');
    emit('close');
}

const acceptChanges = async () => {

    console.log(activeResource.value.sub_resources.map(elem=>elem.id));
    if(activeResource.value.id == null){
        await resourceService.createResource({
            title: activeResource.value.title,
            description: activeResource.value.description,
            examples: activeResource.value.examples,
            sub_resources : activeResource.value.sub_resources.map(elem => elem.id)});


        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Подкатегория успешно добавлена!',
            life: 3000
        })
    }
    else {

        await resourceService.updateResource(activeResource.value.id,{

            title: activeResource.value.title,
            description: activeResource.value.description,
            examples: activeResource.value.examples,
            sub_resources : activeResource.value.sub_resources.map(elem => elem.id)});

        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные подкатегории были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteResource = async ()=>{
    let id = activeResource.value.id;
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
            handleClose()
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


</script>

<style scoped>

</style>
