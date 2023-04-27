import axios from '../../axios/axios-instance'

const state = {

    users : [],
    activeUser: {
        id: null,
        name: '',
        first_name: '',
        patronymic: '',
        tel_number: '',
        email: '',
        company: null
    },
};

const getters = {
    users: (state) => state.users,
    activeUser: (state) => state.activeUser
}

const actions = {
    fillUsers({commit}, drivers){
        commit('fill_users', drivers);
    },
    addUser({commit}, value){
        commit('add_users', value);
    },
    setActiveUser({commit}, value) {
        commit('set_active_user', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveUser({commit}) {
        commit('clear_active_user');
    }
};

const mutations = {
    fill_users(state, users){
        state.users = users

    },
    add_users(state, value){
        state.users.push(value);
    },
    set_active_user(state,value) {
        state.activeUser = value;
    },
    clear_store(state) {
        state.users = [];
        mutations.clear_active_user(state);
    },
    clear_active_user(state) {
        state.activeUser = {
            id: null,
            name: '',
            first_name: '',
            patronymic: '',
            tel_number: '',
            company: null
        }
    }
}


export default  {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
