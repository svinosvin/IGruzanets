import axios from '../axios/axios-instance'

export default class Auto{

    async getAutos(){
        let response = await axios.get('/api/auto');
        return response.data
    }
    async getAuto(id){
        let response = await axios.get(`/api/auto/${id}`);
        return await response.data[0];
    }
    async createAuto(data){
        let response = await axios.post(`/api/auto`, data);
        return  await response.data[0];
    }
    async updateAuto(id, data){
        let response = await axios.patch(`/api/auto/${id}`, data);
        return await response.data[0];
    }
    async deleteAuto(id){
        let response = await axios.delete(  `/api/auto/${id}`);
        return await response.data[0];
    }

}
