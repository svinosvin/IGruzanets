import axios from '../../axios/axios-instance'
import router from "../../router";

const state = {
    token: localStorage.getItem('user-token') || '',
    user:{
        id: null,
        name: '',
        first_name: '',
        patronymic: '',
        email: '',
        company: null,
        tel_number: '',
    },
    userState: false,
}
const actions = {
    loginUser({commit}, user){
        return new Promise((resolve)=>{
            axios.get('/sanctum/csrf-cookie').then( response =>{
                axios.post('/api/login', {
                    email: user.email,
                    password: user.password

                })
                    .then(response =>{
                        if(response.data ){
                            const token = response.data.token ?? null;
                            const user = response.data.user ?? null;
                            localStorage.setItem('user-token', token);
                            console.log(response.data)
                            commit('auth_user', user, token);
                            resolve(response);
                            if(user)
                                router.push('/')
                            return response.data
                        }
                })
                    .catch((error)=> {
                        console.log(error.response);
                        localStorage.removeItem('user-token')
                        return error.response

                    })
            })
        })
    },
    registerUser({commit}, user){
        return new Promise((resolve)=>{
            axios.get('/sanctum/csrf-cookie').then( response =>{
                axios.post('/api/register', {
                    email: user.email,
                    password: user.password,
                    password_confirmation: user.password_confirmation,
                    tel_number: user.tel_number,
                })
                    .then(response =>{
                        if(response.data){
                            console.log(response);
                            const token = response.data.token;
                            const user = response.data.user;
                            localStorage.setItem('user-token', token);
                            commit('auth_user', user, token);
                            resolve(response);
                            window.location.replace('/')
                        }
                    })
                    .catch((error)=> {
                        console.log(error.response);
                        localStorage.removeItem('user-token')
                    })
            })
        })
    },
    getDataUser({commit}){
        return new Promise((resolve)=>{
            if(localStorage.getItem('user-token')){
                const token = localStorage.getItem('user-token');
                axios.get('/api/user/profile')
                    .then(response=>{
                        const user = response.data.user;
                        commit('auth_user', user,token);

                    })
                    .catch(error=>{
                        localStorage.removeItem('user-token')
                        commit('auth_user_logout');
                    })
            }

        })
    },
    logoutUser({commit}){
        return new Promise((resolve)=>{
            localStorage.removeItem('user-token')
            commit('auth_user_logout');
            window.location.replace('/')
        })
    }
};

const mutations = {
    auth_user(state, user, token){
        state.user = user;
        state.token = token;
        state.userState = true;
    },
    auth_user_logout(state){
        state.user = {
            id:"",
            name: '',
            first_name: "",
            patronymic: "",
            email: "",
            tel_number: "",
        };
        state.token = '';
        state.userState = false;
    }

}

const getters = {
    currentUser: state => state.user ?? {},
    userToken: state => state.token ?? '',
    userState: state => state.userState ?? false
}



export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
}
