const state = {

    sub_resources : [],
    activeSubResource: {
        id: null,
        title: '',
        description: '',
        examples: '',
        resource: {},
    },
};
const getters = {
    subResources: (state) => state.sub_resources,
    activeSubResource: (state) => state.activeSubResource,
    smallSubResources: (state) => {
        const newData = state.sub_resources.map(s => {
                return {
                    id: s.id,
                    title: s.title
                };
            }
        )
        return newData;
    },
}

const actions = {
    fillSubResources({commit}, value){
        commit('fill_subresources', value);

    },
    addSubResource({commit}, value){
        commit('add_subresource', value);
    },
    setActiveSubResource({commit}, value) {
        commit('set_active_subresource', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveSubResource({commit}) {
        commit('clear_active_subresource');
    }
};

const mutations = {
    fill_subresources(state, value){
        state.sub_resources = value
        console.log(state.sub_resources);
    },
    add_subresource(state, value){
        state.sub_resources.push(value);
    },
    set_active_subresource(state,value) {
        state.activeSubResource = value;
    },
    clear_store(state) {
        state.sub_resources = [];
        mutations.clear_active_subresource(state);
    },
    clear_active_subresource(state) {
        state.activeSubResource = {
            id: null,
            title: '',
            description: '',
            examples: '',
            resources: {},
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
