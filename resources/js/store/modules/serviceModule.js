const state = {

    services : [],
    activeService: {
        id: null,
        title: '',
        description: '',
        price_one_unit: 0.1,
        img: null,
        service_type: null,
        resources: [],
    },
    service_types:[],
};
const getters = {
    services: (state) => state.services,
    activeService: (state) => state.activeService,
    service_types: (state) => state.service_types,
}

const actions = {
    fillServices({commit}, value){
        commit('fill_services', value);
    },
    fillServiceTypes({commit}, value){
        commit('fill_service_types', value);
    },
    addService({commit}, value){
        commit('add_service', value);
    },
    setActiveService({commit}, value) {
        console.log(value)
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

    fill_service_types(state, value){
        state.service_types = value
    },
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
            price_one_unit: 0.1,
            img: null,
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
