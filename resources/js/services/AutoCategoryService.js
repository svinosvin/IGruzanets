import axios from '../axios/axios-instance'

export default class AutoCategory{
    async getAutoCategories(){
        let response = await axios.get('/api/auto_category/');
        return await response.data;
    }
    async getAutoCategory(id){
        let response = await axios.get(`/api/auto_category/${id}`);
        return await response.data;
    }
    async createAutoCategory(data){
        let response = await axios.post('/api/auto_category/', data);
        return await response.data[0];
    }
    async updateAutoCategory(id, data){
        let response = await axios.patch(`/api/auto_category/${id}`, data);
        return await response.data[0];
    }
    async destroyAutoCategory(id){
        let response = await axios.delete(`/api/auto_category/${id}`);
        return await response.data[0];
    }
}
