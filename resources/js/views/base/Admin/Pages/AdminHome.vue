<template>
    <div class="  font-bold wrapper p-5 pb-0">
        <h1>Заказы:</h1>
        <Chart class="w-full h-30rem md:w-30rem" type="bar" :data="chartData" :options="chartOptions"/>
    </div>
    <div class="mt-0 pb-40 mb-10">
        <div class="flex  card wrapper font-bold">
            <div class="w-full  pt-10 pl-5">
                <div class="border-b-2 w-full flex mb-5">
                    <h2 class="mr-2"> Текущий администратор: </h2>
                    <div class="font-light">{{currentAdmin.first_name}} {{currentAdmin.name}} {{currentAdmin.patronymic}}</div>
                </div>
                <div class=" border-b-2 w-full flex mb-5">
                    <h2 class="mr-2">Email: </h2>
                    <div class="font-light"> {{currentAdmin.email}}</div>
                </div>
                <div class="border-b-2 w-full flex mb-5">
                    <h2 class="mr-2">Телефон: </h2>
                    <div class="font-light">{{currentAdmin.tel_number}}</div>
                </div>
                <div class="border-b-2 w-full flex mb-5">
                    <h2 class="mr-2">График работы  </h2>
                    <div class="font-light">9:00-20:00</div>

                </div>
            </div>
        </div>


    </div>

</template>

<script setup>

import Chart from 'primevue/chart';
import OrderService from '../../../../services/OrderService';
import OrderQuery from "../../../../services/Query/OrderQuery";
import ServiceService from "../../../../services/ServiceService";

import {useStore} from "vuex"
import {computed, onMounted, ref} from "vue";


//uses
const store = useStore();
const currentAdmin = computed(()=>store.state.authAdmin.admin);
//
const serviceService = new ServiceService();
const orderService = new OrderService();
const loadedData = ref(false)

const orderLabels = ref([])

const dataChart = ref([])

const chartData = ref({
    labels: orderLabels,
    datasets: [
        {
            label: 'Количество заказов за все время',
            data: dataChart,
            borderWidth: 1
        }
    ]
});

// const chartData1 = ref({
//     labels: orderLabels,
//     datasets: [
//         {
//             label: 'Количество заказов за все время',
//             data: dataChart,
//             borderWidth: 1
//         }
//     ]
// })

const loadData = async () => {

    let newOrdersLabel = [];
    let newDataChart = [];
        await serviceService.getServices().then(data => {
            data.data.forEach( x => {
                newOrdersLabel.push(x.title);
                newDataChart.push(0);
        })
    })
    console.log(newOrdersLabel);
    console.log(newDataChart);
    await orderService.getOrders(new OrderQuery()).then(data => {
        const orders = data.data;
        for (let i = 0; i < newOrdersLabel.length; i++){
            for (let j = 0; j < orders.length; j++){
                    if(newOrdersLabel[i] == orders[j].service.title){
                        newDataChart[i] = ++newDataChart[i];
                    }
            }
        }
    })

    orderLabels.value = newOrdersLabel
    dataChart.value = newDataChart;
}


const chartOptions = ref({
    scales: {
        y: {
            beginAtZero: true
        }
    }
});

onMounted(async ()=>{
    await loadData()
})

</script>

<style lang="scss" scoped>

.wrapper{

    border: 2px solid #a9a7a7;
}
.wrapper:first-child{

    border: 2px solid #a9a7a7;
    border-bottom: none;
}
.wrapper:last-child{

    border: 2px solid #a9a7a7;
    border-top: none;
}

</style>
