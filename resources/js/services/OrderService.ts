import axios from '../axios/axios-instance'

import OrderQuery from "./Query/OrderQuery";

export default class OrderService{

    async getOrders(query: OrderQuery){
        let response = await axios.get('/api/orders/', {
            params: query.getParams(),
        });
        return await response.data;
    }

    async getOrder(id){
        let response = await axios.get(`/api/orders/${id}`);
        console.log(response);
        return await response.data;
    }
    async createOrder( data){
        let response = await axios.post(`/api/orders/`, data)
        return await response.data[0];
    }
    async updateOrder(id, data){
        let response = await axios.patch(`/api/orders/${id}`, data)
        return await response.data[0];
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
    async acceptOrder(id){
        let response = await axios.get(`/api/orders/acceptOrder/${id}`, );
        return await response.data;

    }
    async finishOrder(id){
        let response = await axios.get(`/api/orders/finishOrder/${id}`, );
        return await response.data;

    }
    async declineOrder(id){
        let response = await axios.get(`/api/orders/declineOrder/${id}`, );
        return await response.data;
    }
    async deleteOrder(id){
        let response = await axios.delete(`/api/orders/${id}`, );
        return await response.data;
    }
}
