import axios from '../../axios/axios-instance'

const state = {

    drivers : [],
    activeDriver: {
        name: 0,
        last_name: 0,
        patronymic: 0,
        tel_number: 0,
        categories : []
    },
};
const getters = {
    drivers: (state) => state.drivers,
    activeDriver: (state) => state.activeDriver
}

const actions = {
    fillDrivers({commit}, drivers){
        commit('fill_drivers', drivers);
    },
    addDriver({commit}, value){
        commit('add_driver', value);
    },
    setActiveDriver({commit}, value) {
        commit('set_active_driver', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveDriver({commit}) {
        commit('clear_active_driver');
    }
};

const mutations = {
    fill_drivers(state, drivers){
        state.drivers = drivers;
    },
    add_driver(state, value){
        state.drivers.push(value);
    },
    set_active_driver(state,value) {
        state.activeDriver = value;
    },
    clear_store(state) {
        state.drivers = [];
        mutations.clear_active_driver(state);
    },
    clear_active_driver(state) {
        this.activeDriver = {
            name: 0,
            last_name: 0,
            patronymic: 0,
            tel_number: 0,
            categories : []
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
