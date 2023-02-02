import axios from '../axios/axios-instance'

export default class Resource{

    async getResources(){
        let response = await axios.get('/api/resource/');
        return await response.data;
    }
    async getResource(id){
        let response = await axios.get(`/api/resource/${id}`)
        return await response.data;
    }
    async createResource(data){
        let response = await axios.post(`/api/resource/`, data);
        return await response.data[0];
    }
    async updateResource(id, data){
        let response = await axios.patch(`/api/resource/${id}`, data);
        return await response.data[0];
    }
    async deleteResource(id){
        let response = await axios.delete(`/api/resource/${id}`);
        return await response.data[0];
    }
}
