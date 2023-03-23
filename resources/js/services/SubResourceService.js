import axios from '../axios/axios-instance'

export default class SubResource{

    async getSubResources(){
        let response = await axios.get('/api/sub_resource/');
        return await response.data;
    }
    async getSubResource(id){
        let response = await axios.get(`/api/sub_resource/${id}`)
        return await response.data;
    }
    async createSubResource(data){
        let response = await axios.post(`/api/sub_resource/`, data);
        return await response.data[0];
    }
    async updateSubResource(id, data){
        let response = await axios.patch(`/api/sub_resource/${id}`, data);
        return await response.data[0];
    }
    async deleteSubResource(id){
        let response = await axios.delete(`/api/sub_resource/${id}`);
        return await response.data[0];
    }
}
