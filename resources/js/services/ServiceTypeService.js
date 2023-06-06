import axios from '../axios/axios-instance'


export default class ServiceTypeService {

    async getServiceTypes(){
        let response = await axios.get('/api/service_types/');
        return await response.data;
    }
}
