import axios from '../../axios/axios-instance'

const state = {
    status: '',
    token: localStorage.getItem('token') || '',
    admin: {}
}
const actions = {
    loginAdmin({commit}, admin){
        return new Promise((resolve)=>{
            axios.get('/sanctum/csrf-cookie').then( response =>{
                axios.post('/api/admin/login', {
                    email: admin.email,
                    password: admin.password

                })
                    .then(response =>{
                        console.log(response)
                        const token = response.data.token;
                        const admin = response.data.admin;
                        localStorage.setItem('token', token);
                        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
                        commit('auth_success', token, admin);
                        resolve(response);
                })
                    .catch((error)=> {
                        commit('auth_error')
                        console.log(error.response);
                        localStorage.removeItem('token')
                })
            })
        })
    },
    logoutAdmin({commit}){
        return new Promise((resolve)=>{
            commit('logout');
            localStorage.removeItem('token')
            delete axios.defaults.headers.common['Authorization'];
            resolve();

        })
    }
}

const mutations = {

    auth_request(state){
        state.status = 'loading';
    },
    auth_success(state,token, admin){
        state.status = 'success';
        state.token = token;
        state.admin = admin;
    },
    auth_error(state){
        state.status = '';
        state.token = '';
    },
    logout(state){
        state.status = '';
        state.token = '';
    },
}
const getters = {

    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
}

export default {
    namespace: true,
    state,
    actions,
    mutations,
    getters,
}
