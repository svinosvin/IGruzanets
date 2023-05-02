import axios from '../axios/axios-instance'

export default class UserService{

    async login(data){
         await axios.get('/sanctum/csrf-cookie').then( response =>{
            let resp = axios.post('/api/login', data)
            return resp.data;
        })
    }
    async register(data){
        let response = await axios.post('/api/register', data)
        return response.data;
    }
    async updateUserData(id, data){
        await axios.get('/sanctum/csrf-cookie').then( response => {
            let res = axios.patch(`/api/user/updateProfile/${id}`, data);
            console.log(res);
            return response.data[0];
        })
    }

    async getProfile(){
        let response = await axios.get('/api/user/profile')
        return response.data;
    }

    async getUsers(){
        let response = await axios.get('/api/users/');
        return await response.data;
    }
    async getUser(id){
        let response = await axios.get(`/api/users/${id}`)
        return await response.data;
    }
    async createUser(data){
        let response = await axios.post(`/api/users/`, data);
        return await response.data[0];
    }
    async updateUser(id, data){
        let response = await axios.patch(`/api/users/${id}`, data);
        console.log(response.data);
        return await response.data[0];
    }
    async deleteUser(id){
        let response = await axios.delete(`/api/users/${id}`);
        return await response.data[0];
    }
}
