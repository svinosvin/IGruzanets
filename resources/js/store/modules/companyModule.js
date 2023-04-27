import axios from '../../axios/axios-instance'

const state = {

    companies : [],
    activeCompany: {
        id: null,
        title: '',
        email:'',
        is_email_verified:false,

    },
};

const getters = {
    companies: (state) => state.companies,
    activeCompany: (state) => state.activeCompany
}

const actions = {
    fillCompanies({commit}, drivers){
        commit('fill_companies', drivers);
    },
    addCompany({commit}, value){
        commit('add_company', value);
    },
    setActiveCompany({commit}, value) {
        commit('set_active_company', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveCompany({commit}) {
        commit('clear_active_company');
    }
};

const mutations = {
    fill_companies(state, companies){
        state.companies = companies

    },
    add_company(state, value){
        state.companies.push(value);
    },
    set_active_company(state,value) {
        state.activeCompany = value;
    },
    clear_store(state) {
        state.companies = [];
        mutations.clear_active_company(state);
    },
    clear_active_company(state) {
        state.activeCompany = {
            id: null,
            title: '',
            email:'',
            is_email_verified:false,
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
