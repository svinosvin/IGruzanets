import axios from '../axios/axios-instance'

export default class ReviewService{

    async getReviews(){
        let response = await axios.get('/api/reviews/');
        return await response.data;
    }
    async getReview(id){
        let response = await axios.get(`/api/reviews/${id}`)
        return await response.data;
    }
    async createReview(data){
        await axios.get('/sanctum/csrf-cookie').then( response =>{
            let re =  axios.post(`/api/reviews/`, data);
            return  response.data;
        })
    }
    async updateReview(id, data){
        let response = await axios.patch(`/api/reviews/${id}`, data);
        return await response.data[0];
    }
    async deleteReview(id){
        let response = await axios.delete(`/api/reviews/${id}`);
        return await response.data[0];
    }
}
