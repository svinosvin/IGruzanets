const state = {

    autos : [],
    activeAuto: {
        id: null,
        mark: null,
        description: '',
        img: '',
        max_weight: 0.5,
        car_numbers: '',
        auto_category: null,
        service: null,
        is_active: '',
    },
};
const getters = {
    autos: (state) => state.autos,
    activeAuto: (state) => state.activeAuto
}

const actions = {
    fillAutos({commit}, value){
        commit('fill_autos', value);
    },
    addAuto({commit}, value){
        commit('add_auto', value);
    },
    setActiveAuto({commit}, value) {
        commit('set_active_auto', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveAuto({commit}) {
        commit('clear_active_auto');
    }
};

const mutations = {
    fill_autos(state, value){
        state.autos = value;
    },
    add_auto(state, value){
        state.autos.push(value);
    },
    set_active_auto(state,value) {
        state.activeAuto = value;
    },
    clear_store(state) {
        state.autos = [];
        mutations.clear_active_auto(state);
    },
    clear_active_auto(state) {
        state.activeAuto =  {
            id: null,
            mark: null,
            description: '',
            img: '',
            max_weight: 0.5,
            car_numbers: '',
            auto_category: null,
            service: null,
            is_active: '',
        };
    }
}


export default  {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
