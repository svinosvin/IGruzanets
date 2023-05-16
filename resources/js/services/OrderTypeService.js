import axios from '../axios/axios-instance'


export default class OrderTypeService {

    async getOrderTypes(){
        let response = await axios.get('/api/order_types/');
        return await response.data;
    }
}
