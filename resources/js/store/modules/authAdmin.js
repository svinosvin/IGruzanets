import axios from '../../axios/axios-instance'

const state = {
    token: localStorage.getItem('admin-token') || '',
    admin: {
        name: 0,
        first_name: 0,
        patronymic: 0,
        email: 0,
        tel_number: 0,

    },
    state: false,
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
                        if(response.data.admin){
                            const token = response.data.token;
                            const admin = response.data.admin;
                            localStorage.setItem('admin-token', token);
                            commit('auth_admin', admin, token);
                            window.location.replace('/admin/')
                        }
                })
                    .catch((error)=> {
                        console.log(error.response);
                        localStorage.removeItem('admin-token')
                })
            })
        })
    },

    logoutAdmin({commit}){
        return new Promise((resolve)=>{
            localStorage.removeItem('admin-token')
            commit("auth_admin_logout");
            resolve();
            window.location.replace('/admin/login')
        })
    },

    getDataAdmin({commit}){
        return new Promise((resolve)=>{
          if(localStorage.getItem('admin-token')){
              const token = localStorage.getItem('admin-token');
              axios.get('/api/admin/data')
                  .then(response=>{
                      const admin = response.data.admin;
                      commit('auth_admin', admin,token);

              })
              .catch(error=>{
                  localStorage.removeItem('admin-token')
                  commit('auth_admin_logout');
              })
          }

        })
    }

}

const mutations = {

    auth_admin(state, admin, token){
        state.admin = admin;
        state.token = token;
        state.state = true;
    },
    auth_admin_logout(state){
        state.admin = {
            name: 0,
            first_name: 0,
            patronymic: 0,
            email: 0,
            tel_number: 0,

        };
        state.token = '';
        state.state = false;
    },

}
const getters = {
    currentAdmin: state => state.admin,
    adminToken: state => state.token,
    adminState: state => state.state,


}


export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
   // computed
}
