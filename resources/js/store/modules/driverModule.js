import axios from '../../axios/axios-instance'

const state = {

    drivers : [],
    activeDriver: {
        id: null,
        name: '',
        img: null,
        first_name: '',
        patronymic: '',
        tel_number: '',
        categories : [],
        categoriesString: null,
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
        state.drivers = drivers.map( x => {
            return {
                id: x.id,
                name: x.name,
                img: x.img,
                first_name: x.first_name,
                patronymic: x.patronymic,
                tel_number: x.tel_number,
                categories : x.categories,
                categoriesString: x.categories.map(x=>x.title).join('; '),
            }
        })

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
        state.activeDriver = {
            id: null,
            name: '',
            img: null,
            first_name: '',
            patronymic: '',
            tel_number: '',
            categories : [],
            categoriesString: null
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
