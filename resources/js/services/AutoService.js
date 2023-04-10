import axios from '../axios/axios-instance'
import axiosPost from '../axios/axios-instance-post'


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
        let response = await axiosPost.post(`/api/auto/`, data);
        console.log(response.data);
        return  await response.data[0];
    }
    async updateAuto(id, data){
        console.log(data);
        console.log(id);
        let response = await axiosPost.post(`/api/auto/${id}`, data);
        console.log(response.data);
        return await response.data[0];
    }
    async deleteAuto(id){
        let response = await axios.delete(  `/api/auto/${id}`);
        return await response.data[0];
    }

}
