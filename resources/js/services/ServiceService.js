import axios from '../axios/axios-instance'
import axiosPost from '../axios/axios-instance-post'

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
        let response = await axiosPost.post(`/api/service/`, data);
        console.log(response.data);
        return await response.data[0];
    }
    async updateService(id, data){
        let response = await axiosPost.post(`/api/service/${id}`, data);
        console.log(response.data);
        return await response.data[0];
    }
    async deleteService(id){
        let response = await axios.delete(`/api/service/${id}`);
        return await response.data[0];
    }
}
