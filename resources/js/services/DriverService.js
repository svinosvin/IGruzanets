import axios from '../axios/axios-instance'

export default class Driver{

    async getDrivers(){
        let response = await axios.get('/api/driver/');
        return await response.data;
    }
    async getDriver(id){
        let response = await axios.get(`/api/driver/${id}`)
        return await response.data;
    }
    async createDriver(data){
        let response = await axios.post(`/api/driver/`, data);
        return await response.data[0];
    }
    async updateDriver(id, data){
        let response = await axios.patch(`/api/driver/${id}`, data);
        return await response.data[0];
    }
    async deleteDriver(id){
        let response = await axios.delete(`/api/driver/${id}`);
        return await response.data[0];
    }
}
