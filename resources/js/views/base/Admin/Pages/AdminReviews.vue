<template>
    <AdminPageWrapper headerPage="Отзывы">
        <template v-slot:header>
            <Toolbar class="mb-4 flex flex-wrap">
                <template #start>
                    <Dropdown @change="" v-model="is_active"  :options="[{title: 'По умолчанию', status: ''}, {title: 'Включены', status: true},{title: 'Отключены', status: false} ]"
                              optionLabel="title" class="mr-5 w-full"  placeholder="По умолчанию" :filter="true">
                    </Dropdown>
                    <div>
                        <Button  label="Сбросить" icon="pi pi-cross" class="p-button mr-5" @click="resetButton" />
                    </div>
                </template>
                <template #end>
                </template>
            </Toolbar>
        </template>
        <template v-slot:main>
            <DataTable ref="dt" style=""  :class="`p-datatable-sm`"
                       :value="reviews" :sortOrder="2" :autoLayot="true" :paginator="true" :rows="3"
                       showGridlines
                       removableSort :lazy="true"
                       scrollable
                       @page="onPage($event)"
                       paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                       :total-records="totalRecords"
            >
                <template #header>
                    <span class="text-3xl">Отзывы</span>
                </template>
                <Column field="" header="Инфо">
                    <template #body="slotProps">
                        <div class="flex-col">
                            <div v-if="slotProps.data.user!=null" class="flex flex-col">
                                <div class="font-bold text-3xl pb-4">Аккаунт</div>
                                <div class="w-full flex">
                                    <h2 class="font-bold mr-2">ФИО: </h2>
                                    <div>{{`${slotProps.data.user.first_name ?? ''}  ${slotProps.data.user.name}  ${slotProps.data.user.first_name ?? ''}`}}</div>
                                </div>
                                <div class="w-full flex">
                                    <h2 class="font-bold mr-2">Телефон: </h2>
                                    <div>{{slotProps.data.user.tel_number}}</div>
                                </div>
                                <div class="w-full flex">
                                    <h2 class="font-bold mr-2">Email: </h2>
                                    <div>{{slotProps.data.user.email}}</div>
                                </div>
                                <div class="font-bold text-3xl pb-2 pt-4">Отзыв:</div>
                                <div class="w-full flex-col">
                                    <h2 class="font-bold mr-2">Содержание: </h2>
                                    <div>{{slotProps.data.review}}</div>
                                </div>
                            </div>
                        </div>

                    </template>
                </Column>
                <Column field="" header="Видимость" class="flex justify-center">
                    <template #body="slotProps">
                        <div class="font-bold">
                            <!--                         <ToggleButton v-model="slotProps.data.is_active" onLabel="Включен" offLabel="Выключен"-->
                            <!--                                       onIcon="pi pi-check" offIcon="pi pi-times" class="w-9rem" />-->

                            <CustomToggle v-on:update-check="updateVisibility" @click="setActiveReview(slotProps.data)"  v-model="slotProps.data.is_active"/>
                        </div>
                    </template>
                </Column>
                <Column :exportable="false" class="flex justify-center" style="min-width:6rem">
                    <template #body="slotProps">
                        <div>
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger" label="Удалить" @click="deleteReview(slotProps.data.id)"/>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </AdminPageWrapper>
    <!--    <AutoDialog @close="handleCloseDialog" v-model:visible="openDialog"></AutoDialog>-->
</template>

<script setup>

import {computed, onMounted, onUnmounted, ref,watch} from "vue";
import ReviewService from '../../../../services/ReviewService'

import { useStore } from 'vuex';
import {useConfirm} from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import CustomToggle from '../../../../components/ui/CustomToggle.vue'
import ReviewQuery from "../../../../services/Query/ReviewQuery";
const toast = useToast();
const confirm = useConfirm();
const query = new ReviewQuery(1, 3);

//refs
const store = useStore();
const reviewService = new ReviewService();
const dt = ref()
const is_active = ref({title: 'По умолчанию', status: ''});
const openDialog = ref(false);
const checked = ref(false);
const totalRecords = ref(0);
const lazyParams = ref({});
//refs
//
// const filter = ref({
//     'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
//     'categoriesString': {value: null, matchMode: FilterMatchMode.CONTAINS},
// })


//computed
const activeReview = computed(()=>store.getters['reviewModule/activeReview']);
const reviews = computed(()=>store.getters['reviewModule/reviews']);


//methods

const setActiveReview = (data)=>{
    store.dispatch('reviewModule/setActiveReview', data);
}

const updateVisibility = async (data)=>{
    await confirm.require({
        message:`Вы точно хотите изменить видимость комментария №${activeReview.value.id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            activeReview.value.is_active = data;
            console.log(activeReview.value.is_active);
            await reviewService.updateReview( activeReview.value.id, {
                review: activeReview.value.review,
                is_active: activeReview.value.is_active,
                user_id: activeReview.value.user != null ? activeReview.value.user.id : null,
            });
            await toast.add({
                severity:'success',
                summary: 'Изменено!',
                detail:'Комментарий успешно изменен!',
                life: 3000
            })
            await fillReviews();

        },
        reject: () => {
            console.log('dasdas')
            store.dispatch('reviewModule/clearStore');

            loadOptions();

        },
        onShow: () => {
            //callback to execute when dialog is shown
        },
        onHide: () => {
            //callback to execute when dialog is hidden
        }
    });

}

const dblclickHandlerAuto = (event) =>{
    setActiveReview(event.data);
    openDialog.value = true;
}



const fillReviews = async () =>{

    await reviewService.getReviews(query).then(data => {
        let newReviews = data.data.map( x => {
            return {
                id: x.id,
                review: x.review,
                user: x.user,
                is_active: x.is_active == 1 ? true : false,

            }
        })
        store.dispatch('reviewModule/fillReviews', data.data);
        totalRecords.value = data.meta.total
    })
};

const loadOptions = async (reset = false) =>{
    const page  = reset ? 1 : lazyParams.value.page + 1;
    let query = new ReviewQuery( page,3);

    if(reset == false) {

        if (is_active.value.title != "По умолчанию") {
            query.addFilter(query.IS_ACTIVE, is_active.value.status);
        } else {
            query.removeFilter(query.IS_ACTIVE)
        }
    }
    else {
        query.deleteParams();
    }
    await reviewService.getReviews(query).then(data => {
        let newReviews = data.data.map( x => {
            return {
                id: x.id,
                review: x.review,
                user: x.user,
                is_active: x.is_active == 1 ? true : false,

            }
        })
        store.dispatch('reviewModule/fillReviews', data.data);
        totalRecords.value = data.meta.total
    })
    if (reset) {
        lazyParams.value.page = 1;
        dt.value.resetPage();
    }
}
watch(is_active, () =>{
    loadOptions();
})
const resetButton = async () =>{
    is_active.value = {title: 'По умолчанию', status: ''};
    lazyParams.value.page = 0;
    loadOptions();


}

const onPage = (event) => {
    lazyParams.value = event;

    loadOptions();
};
const clearActiveReview = ()=>{
    store.dispatch('reviewModule/clearActiveReview');
}


//handlers


//crud
const deleteReview = async (id)=>{
    await confirm.require({
        message:`Вы точно хотите удалить комментарий №${id}?`,
        header: 'Подтверждение',
        icon: 'pi pi-exclamation-triangle',
        accept: async () => {
            await reviewService.deleteReview(id);
            await toast.add({
                severity:'success',
                summary: 'Удалено!',
                detail:'Комментарий успешно удален!',
                life: 3000
            })
            await loadOptions();
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
    lazyParams.value = {
        first: 0,
        rows: dt.value.rows,
        sortField: null,
        sortOrder: null,
        page: 0,
    };
    loadOptions()
})

onUnmounted(()=>{
    store.dispatch('reviewModule/clearStore');
})

</script>

<style scoped>

</style>
