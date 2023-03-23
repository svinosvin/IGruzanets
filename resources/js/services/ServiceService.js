import axios from '../axios/axios-instance'

export default class Service{

    async getServices(){
        let response = await axios.get('/api/service/');
        return await response.data;
    }
    async getService(id){
        let response = await axios.get(`/api/service/${id}`)
        return await response.data;
    }
    async createService(data){
        let response = await axios.post(`/api/service/`, data);
        return await response.data[0];
    }
    async updateService(id, data){
        let response = await axios.patch(`/api/service/${id}`, data);
        return await response.data[0];
    }
    async deleteService(id){
        let response = await axios.delete(`/api/service/${id}`);
        return await response.data[0];
    }
}
