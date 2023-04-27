import axios from '../axios/axios-instance'

export default class CompanyService{



    async getCompanies(){
        let response = await axios.get('/api/companies/');
        console.log(response.data);
        return await response.data;
    }

    async getCompany(id){
        let response = await axios.get(`/api/companies/${id}`)
        return await response.data;
    }
    async createCompany(data){
        let response = await axios.post(`/api/companies/`, data);
        return await response.data[0];
    }
    async updateCompany(id, data){
        let response = await axios.patch(`/api/companies/${id}`, data);
        return await response.data[0];
    }
    async deleteCompany(id){
        let response = await axios.delete(`/api/companies/${id}`);
        return await response.data[0];
    }
}
