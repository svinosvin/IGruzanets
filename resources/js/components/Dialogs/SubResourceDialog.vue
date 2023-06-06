<template>
    <Dialog  :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Подкатегория</h3>
        </template>
        <Form :validation-schema="schema"  validate-on-mount @submit="acceptChanges">

        <div class="flex-column justify-center">
            <div class="mb-6">
                <h2 class="font-bold">Категория</h2>
                <Dropdown v-model="activeSubresource.resource"  :options="[{'id':null,'title':'Выберите категорию', 'description': '', 'examples': ''}, ...resources]"
                          optionLabel="title" class="w-full"  placeholder="Выберите категорию" :filter="true" filterPlaceholder="Найти категорию">
                </Dropdown>

            </div>
            <div class="mb-6">
                <h2 class="font-bold">Название</h2>
                <InputText v-model="activeSubresource.title" class="w-full"></InputText>
                <ValidationComponent name="title" v-model="activeSubresource.title"></ValidationComponent>
            </div>
            <div class="mb-6">
                <h2 class="font-bold">Описание</h2>
                <Textarea v-model="activeSubresource.description" class="w-full" :autoResize="true" rows="5" cols="50" />
            </div>
            <div class="mb-6">
                <h2 class="font-bold">Примеры </h2>
                <Textarea v-model="activeSubresource.examples" class="w-full"  :autoResize="true" rows="5" cols="50" />
            </div>
        </div>
        </Form>
        <template #footer>
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeSubresource.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteSubResource"/>
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
import * as yup from "yup";
import { Form, Field, ErrorMessage} from 'vee-validate';


const schema = yup.object().shape({
    title: yup.string().required(()=>'Название подкатекогории - обязательное поле'),
});
//uses
const toast = useToast();
const confirm = useConfirm();
const store = useStore();
const resourceService = new ResourceService();
const sresourceService = new SubResourceService()


const emit = defineEmits(['close'])

//computed
const activeSubresource = computed(()=>store.getters['subresourceModule/activeSubResource']);
const resources = computed(()=>store.getters['resourceModule/resources']);
//methods

const handleClose = () => {

    store.dispatch('subresourceModule/clearActiveSubResource');
    emit('close');
}

const acceptChanges = async () => {

    if(activeSubresource.value.id == null){

        await sresourceService.createSubResource({
            title: activeSubresource.value.title,
            description: activeSubresource.value.description,
            examples: activeSubresource.value.examples,
            resource : activeSubresource.value.resource !=null ? activeSubresource.value.resource.id :  null });

        toast.add({
            severity:'success',
            summary: 'Добавлен новый элемент',
            detail:'Подкатегория успешно добавлена!',
            life: 3000
        })
    }
    else {

        await sresourceService.updateSubResource(activeSubresource.value.id,{

            title: activeSubresource.value.title,
            description: activeSubresource.value.description,
            examples: activeSubresource.value.examples,
            resource : activeSubresource.value.resource !=null ? activeSubresource.value.resource.id :  null });



        toast.add({
            severity:'success',
            summary: 'Данные обновлены',
            detail:'Данные подкатегории были обновлены!',
            life: 3000
        })
    }

    handleClose();

}

const deleteSubResource = async ()=>{
    let id = activeSubresource.value.id;
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
}


</script>

<style scoped>

</style>
