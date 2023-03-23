const state = {

    services : [],
    activeService: {
        id: null,
        title: '',
        description: '',
        services: [],
    },
};
const getters = {
    services: (state) => state.services,
    activeService: (state) => state.activeService

}

const actions = {
    fillServices({commit}, value){
        commit('fill_services', value);
    },
    addService({commit}, value){
        commit('add_service', value);
    },
    setActiveService({commit}, value) {
        commit('set_active_service', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveService({commit}) {
        commit('clear_active_service');
    }
};

const mutations = {
    fill_services(state, value){
        state.services = value
    },
    add_service(state, value){
        state.services.push(value);
    },
    set_active_service(state,value) {
        state.activeService = value;
    },
    clear_store(state) {
        state.services = [];
        mutations.clear_active_service(state);
    },
    clear_active_service(state) {
        state.activeService = {
            id: null,
            title: '',
            description: '',
            resources: [],
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
