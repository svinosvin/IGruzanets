<template>
    <div class="card">
        <Chart type="bar" :data="chartData" :options="chartOptions"/>
    </div>
</template>

<script setup>

import Chart from 'primevue/chart';
import {onMounted, ref} from "vue";
import OrderService from '../../../../services/OrderService';
import OrderQuery from "../../../../services/Query/OrderQuery";
import ServiceService from "../../../../services/ServiceService";
import { useStore } from 'vuex';


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
