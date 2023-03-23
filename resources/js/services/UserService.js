import axios from '../axios/axios-instance'

export default class UserService{

    async getProfile(){
        let response = await axios.get('/api/user/profile')
        return response.data;
    }
}
