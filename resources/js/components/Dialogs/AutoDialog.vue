<template>
    <Dialog @hide="handleClose()" :modal="true" :style="{width: '50vw'}">
        <template #header>
            <h3>Грузовики и Машины</h3>
        </template>
        <Form :validation-schema="schema"  validate-on-mount @submit="acceptChanges">
        <div class="flex-column justify-center">
            <div class="mb-3">
                <h2>Картинка машины</h2>
                <Upload placeholder="dsadas" :source="activeAuto.img" v-model="file"/>
            </div>
            <div class="mb-3  field field">
                <h2>Какая услуга подходит машине</h2>
                <Dropdown v-model="activeAuto.service" :options="[{'id':null,'title':'Выберите конкретную услугу',}, ...services]"
                          optionLabel="title" class="w-full"  placeholder="Выберите конкретную услугу" :filter="true" filterPlaceholder="Найти категорию">
                </Dropdown>
                <div v-if="services.length>0 && activeAuto.service!=null">
                    <ValidationComponent  name="service" v-model="activeAuto.service.id"></ValidationComponent>
                </div>
            </div>
            <div class="mb-3 field">
                <h2>Марка машины</h2>
                <InputText aria-describedby="dasdsa"  name="mark" class="w-full field" v-model="activeAuto.mark"></InputText>
                <ValidationComponent name="mark" v-model="activeAuto.mark"></ValidationComponent>
            </div>
            <div class="mb-3 field">
                <h2>Описание</h2>
                <Textarea v-model="activeAuto.description" name="description" class="w-full"  :autoResize="true" rows="2" cols="50" />
                <ValidationComponent name="description" v-model="activeAuto.description" ></ValidationComponent>

            </div>
            <div class="mb-3 field flex-col">
                <div class="flex">
                    <div class="mr-7 field">
                        <h2>Грузоподъемность в (т.)</h2>
                        <InputNumber v-model="activeAuto.max_weight" inputId="horizontal-buttons" showButtons buttonLayout="horizontal" mode="decimal" :step="0.25" :min="0.5" :max="50" />
                    </div>
                    <div class="field">
                        <h2>Номер автомобиля</h2>
                        <InputMask  name="car_numbers" v-model="activeAuto.car_numbers" mask="9999 aa-9" placeholder="3333 AI-7" />
                    </div>
                </div>
                <div>
                    <ValidationComponent name="car_numbers" v-model="activeAuto.car_numbers"></ValidationComponent>
                </div>
            </div>
            <div class="field">
                <h2>Какая водительская категория подходит</h2>
                <Dropdown v-model="activeAuto.auto_category" :options="[{'id':null,'title':'Выберите водительскую категорию',}, ...categories]"
                          optionLabel="title" class="w-full"  placeholder="Выберите водительскую категорию" :filter="true" filterPlaceholder="Найти категорию">
                </Dropdown>
                <ValidationComponent v-if="categories.length>0 && activeAuto.auto_category!=null" name="auto_category" v-model="activeAuto.auto_category.id"></ValidationComponent>
            </div>
        </div>
        </Form>
    <template #footer>
        <div class="footer">
            <div class="footer-wrapper flex justify-between">
                <div>
                    <Button label="Удалить" v-if="activeAuto.id !=null" icon="pi pi-trash" class="p-button-danger" @click="deleteAuto"/>
                </div>
                <div>
                    <Button label="Отмена" icon="pi pi-times" class="p-button-text" @click="handleClose"/>
                    <Button label="Сохранить" icon="pi pi-check" autofocus @click="acceptChanges"/>
                </div>
            </div>
        </div>
    </template>
    </Dialog>
</template>

<script setup>
import {computed, ref, toRef, watch} from "vue";
import {useStore} from "vuex";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import AutoService from "../../services/AutoService";
import InputNumber from 'primevue/inputnumber';
import { Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';


//VALIDATION SCHEMA
const schema = yup.object().shape({
    service: yup.string().required(()=>'Поле должно быть выбрано'),
    mark: yup.string().required(() => "Марка машины - обязательное поле"),
    description:  yup.string().required(() => "Описание - обязательное поле"),
    car_numbers: yup.string().required(() => "Номера автомобиля - обязательное поле"),
    auto_category: yup.number().required(() => "Поле должно быть выбрано"),
});


const emit = defineEmits(['close'])

const confirm = useConfirm();
const store = useStore();
const toast = useToast();
const error = ref(false)
//refs
const autoService = new AutoService();

//computed
const activeAuto = computed(()=>store.getters['autoModule/activeAuto']);
const categories = computed(()=>store.getters['autoCategoryModule/autoCategoriesMin']);
const services = computed(()=>store.getters['serviceModule/services']);

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
const acceptChanges = async (values) => {

    error.value =false;
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
    if(activeAuto.value.service){
        data.append('service', activeAuto.value.service.id);
    }
    else {
        data.append('service', null);
    }
    if(activeAuto.value.id == null){

       await autoService.createAuto(data).catch(e=>{
           toast.add({
               severity:'warn',
               summary: 'Возникла ошибка при добавлении',
               life: 3000
           })

       }).then(()=>{
           if(!error.value)
               toast.add({
               severity:'success',
               summary: 'Добавлен новый элемент',
               detail:'Авто успешно добавлено!',
               life: 3000
           })
           handleClose();

       })
    }
    else {
        await autoService.updateAuto(activeAuto.value.id, data).catch(e=>{
            if(e)
                error.value = true;
                toast.add({
                    severity:'warn',
                    summary: 'Возникла ошибка при изменении',
                    life: 3000
                })
        }).then(()=>{
            if(!error.value)
                toast.add({
                    severity:'success',
                    summary: 'Добавлен новый элемент',
                    detail:'Авто успешно изменено!',
                    life: 3000
                })
        })


    }
    if(!error.value)
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
