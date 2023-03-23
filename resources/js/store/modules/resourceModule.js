const state = {

    resources : [],
    activeResource: {
        id: null,
        title: '',
        description: '',
        examples: '',
        sub_resources: [],
        services: [],
    },
};
const getters = {
    resources: (state) => state.resources,
    activeResource: (state) => state.activeResource
}

const actions = {
    fillResources({commit}, value){
        commit('fill_resources', value);
    },
    addResource({commit}, value){
        commit('add_resource', value);
    },
    setActiveResource({commit}, value) {
        commit('set_active_resource', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveResource({commit}) {
        commit('clear_active_resource');
    }
};

const mutations = {
    fill_resources(state, value){
        state.resources = value

    },
    add_resource(state, value){
        state.resources.push(value);
    },
    set_active_resource(state,value) {
        state.activeResource = value;
    },
    clear_store(state) {
        state.resources = [];
        mutations.clear_active_resource(state);
    },
    clear_active_resource(state) {
        state.activeResource = {
            id: null,
            title: '',
            description: '',
            examples: '',
            sub_resources: [],
            services: [],
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
