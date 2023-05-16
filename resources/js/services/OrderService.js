import axios from '../axios/axios-instance'

export default class OrderService{

    async getOrders(){
        let response = await axios.get('/api/orders/');
        return await response.data;
    }
    async getOrder(id){
        let response = await axios.get(`/api/orders/${id}`);
        console.log(response);


        return await response.data;
    }
    async findCar(id){
        let response = await axios.get(`/api/orders/findCar/${id}`);
        console.log(response);

        return await response.data;
    }
    async findDriver(id){
        console.log(id);
        let response = await axios.get(`/api/orders/findDriver/${id}`, );
        return await response.data;
    }
}
