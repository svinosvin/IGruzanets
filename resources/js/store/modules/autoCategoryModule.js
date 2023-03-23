import axios from '../../axios/axios-instance'

const state = {

    autoCategories : [],
    autoCategory: {
        id:null,
        title: 0,
        description: 0,
    },
};

const getters = {
    autoCategories: (state) => state.autoCategories,
    activeCategory: (state) => state.autoCategory,
    autoCategoriesMin: (state) => state.autoCategories.map(category => {
        let c = Object.assign({}, category);
        return {
            id : c.id,
            title: c.title
        };
    })
};

const actions = {
    fillCategories({commit}, value){
        commit('fill_categories', value);
    },
    addCategory({commit}, value){
        commit('add_category', value);
    },
    setActiveCategory({commit}, value) {
        commit('set_active_category', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveDriver({commit}) {
        commit('clear_active_category');
    }
};

const mutations = {
    fill_categories(state, value){
        state.autoCategories = value;
    },
    add_category(state, value){
        state.autoCategories.push(value);
    },
    set_active_category(state,value) {
        state.autoCategory = value;
    },
    clear_store(state) {
        state.autoCategory = [];
        mutations.clear_active_category(state);
    },
    clear_active_category(state) {
        this.autoCategory = {
            id:null,
            title: 0,
            description: 0,
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
