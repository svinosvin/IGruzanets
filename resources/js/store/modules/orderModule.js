const state = {

    orders : [],
    activeOrder: {
        id: null,
        driver: null,
        service: null,
        user: null,
        auto: null,
        name : '',
        tel_number : '',
        notice: '',
        address: '',
        weight: '',
        order_type: '',
        total_price: '',
        order_at : '',
    },
    order_types:[],

};
const getters = {
    orders: (state) => state.orders,
    activeOrder: (state) => state.activeOrder,
    order_types: (state) =>state.order_types
}

const actions = {
    fillOrderTypes({commit}, value){
        commit('fill_order_types', value);
    },
    fillOrders({commit}, value){
        commit('fill_orders', value);
    },
    updateOrder({commit}, value){


        commit('update_order', value);
    },
    addOrder({commit}, value){
        commit('add_order', value);
    },
    setActiveOrder({commit}, value) {
        commit('set_active_order', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveOrder({commit}) {
        commit('clear_active_order');
    }
};

const mutations = {
    fill_orders(state, value){
        state.orders = value;
    },
    update_order(state, value) {
        const id = value.id;
        const data = value.data;

        for (let i = 0; i < state.orders.length ; i++) {
            if(state.orders[i].id === id){
                state.orders[i] = data;
            }
        }
    },
    fill_order_types(state, value){
        state.order_types = value;
    },
    add_order(state, value){
        state.orders.push(value);
    },
    set_active_order(state,value) {
        state.activeOrder = value;
    },
    clear_store(state) {
        state.autos = [];
        mutations.clear_active_order(state);
    },
    clear_active_order(state) {
        state.activeOrder =  {
            id: null,
            driver: null,
            service: null,
            user: null,
            auto: null,
            name : '',
            tel_number : '',
            notice: '',
            address: '',
            weight: '',
            order_type: '',
            total_price: '',
            order_at : '',

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
