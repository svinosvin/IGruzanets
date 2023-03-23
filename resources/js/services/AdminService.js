import axios from '../axios/axios-instance'


export default class Admin{

    async profile(){

        let response = await axios.get('/api/admin/profile')
        return await response.data;
    }

}
