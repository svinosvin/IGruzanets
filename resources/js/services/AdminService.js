import axios from '../axios/axios-instance'


export default class Admin{

    async profile(){

        let response = await axios.get('/api/admin/profile')
        return await response.data;
    }


    async getEmployees(){
        let response = await axios.get('/api/employees/');
        return await response.data;
    }
    async getEmployee(id){
        let response = await axios.get(`/api/employees/${id}`)
        return await response.data;
    }
    async createEmployee(data){
        let response = await axios.post(`/api/employees/`, data);
        return await response.data[0];
    }
    async updateEmployee(id, data){
        let response = await axios.patch(`/api/employees/${id}`, data);
        return await response.data[0];
    }
    async deleteEmployee(id){
        let response = await axios.delete(`/api/employees/${id}`);
        return await response.data[0];
    }

}
