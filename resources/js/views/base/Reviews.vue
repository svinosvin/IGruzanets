<template>

    <div
        class="relative pt-14 pb-32 w-full flex flex-col  page-wrapper"
        style="min-height: 75vh;"
    >
        <div  class="text-center font-bold text-5xl text-white mb-10 w-full bg-gray-800 p-5">
            <h1>Отзывы</h1>
        </div>

        <div class="flex flex-col text-white">
            <div class="reviews__wrapper  w-full">
                <div class="review w-full bg-gray-800 "  v-for="review in reviews">
                        <h2 class="review__title  p-4 pl-10 pr-10 w-full">ФИО: {{review.user.name}} {{review.user.first_name}} {{review.user.patronymic}} &nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; Email: {{review.user.email}}</h2>
                        <div class=" p-2 pl-5 pr-5 pt-5">
                            <Textarea readonly v-model="review.review"  :autoResize="true" rows="2" cols="50"  class="w-full bg-white text-black">
                        </Textarea>
                    </div>
                </div>
                <Paginator :lazy="true" :rows="2" class="bg-amber-200"  @page="onPage($event)" :totalRecords="totalRecords"></Paginator>
            </div>
            <div class="w-full review__form mt-20" >

                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-gray-800 w-full mb-6 shadow-lg rounded-lg bg-gray-300"
                                >
                                    <div class="flex-auto p-5 lg:p-10">
                                        <h4 class="text-2xl font-semibold">Хотите поделиться впечатлением от предоставленных услуг?</h4>
                                        <p class="leading-relaxed mt-1 mb-4 text-gray-600">
                                        </p>
                                        <div class="relative w-full mb-3">
                                            <textarea v-model="review.review"
                                            rows="6"
                                            cols="80"
                                            class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                                            placeholder="Очень хороший сервис..."
                                        ></textarea>
                                        </div>
                                        <div class="text-center mt-6">
                                            <button @click="sendMessage"
                                                class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                                                type="button"
                                                style="transition: all 0.15s ease 0s;"
                                            >
                                                Оставить отзыв
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>
</template>
<script setup>
import {useStore} from "vuex";
import ReviewService from '../../services/ReviewService.ts';
import {onMounted, computed,ref, onUnmounted} from "vue";
import Card from "primevue/card"
import router from "../../router";
import Paginator from 'primevue/paginator';
import ReviewQuery from "../../services/Query/ReviewQuery";
import { useToast } from "primevue/usetoast";
const toast = useToast();

const lazyParams = ref({});
const totalRecords = ref(0)
const query = new ReviewQuery(1,3);
const reviewService = new ReviewService();
const store = useStore();
//
const reviews = computed(()=>store.getters['reviewModule/reviews']);
const review = computed(()=>store.getters['reviewModule/activeReview'])
const currentUser = computed(()=>store.getters['authUser/currentUser']);

//methods
const click = (id) =>{
    router.push( `/service/${id}`)
};

const onPage = (event) => {
    lazyParams.value = event;
    loadOptions();
};

const sendMessage = async () =>{
    console.log(review.value.review)
    if(currentUser.value.id != null){

        console.log(currentUser.value.reviews.length)

        if(currentUser.value.reviews.length < 3){

            await reviewService.createReview({
                review: review.value.review,
                user: currentUser.value.id,
                is_active: false,

            })
            toast.add({
                severity:'success',
                summary: 'Успех!',
                detail: 'Комментарий отправлен на модерацию!',
                life: 3000
            });
            store.dispatch('authUser/getDataUser');
            store.dispatch('reviewModule/clearActiveReview');
            loadOptions();

        }
        else {
            toast.add({
                severity:'warn',
                summary: '',
                detail: 'Вы уже отправили максимально допустимое количество отзывов!',
                life: 3000
            })
        }
    }
    else {
        toast.add({
            severity:'error',
            summary: 'Ошибка!',
            detail: 'Вам нужно авторизироваться',
            life: 3000
        })
    }

}

const loadOptions = async (reset = false) =>{
    const page  = reset ? 1 : lazyParams.value.page + 1;
    let query = new ReviewQuery( page,3);

    query.addFilter(query.IS_ACTIVE, 1);

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
    }
}

onMounted(()=>{

    loadOptions();

})
onUnmounted(()=>{
    store.dispatch('reviewModule/clearStore');
})

</script>

<style scoped lang="scss">
$randomNumber: random(255);

.page-wrapper{
    padding-top: 6rem;
    margin: 0 auto;
    max-width: 1300px;
}
.review{
    border-radius: 20px;
    padding-bottom: 1.25rem;
    margin-bottom: 1rem;
}
.review:last-child{
}
.review__title{
    background: #EE5975;
    background: rgba(238,89,117,0.5);

    border-radius: 20px;
}



@media only screen and (max-width: 1020px) {

}
@media only screen and (max-width: 620px) {


}




</style>
