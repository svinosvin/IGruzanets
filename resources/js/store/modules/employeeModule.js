import axios from '../../axios/axios-instance'

const state = {

    employees : [],
    activeEmployee: {
        id: null,
        name: '',
        first_name:'',
        patronymic:'',
        tel_number:'',
        email:'',
        password: '',
        password_confirmation: '',


    },
};

const getters = {
    employees: (state) => state.employees,
    activeEmployee: (state) => state.activeEmployee
}

const actions = {
    fillEmployees({commit}, drivers){
        commit('fill_employees', drivers);
    },
    addEmployee({commit}, value){
        commit('add_employee', value);
    },
    setActiveEmployee({commit}, value) {
        commit('set_active_employee', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveEmployee({commit}) {
        commit('clear_active_employee');
    }
};

const mutations = {
    fill_employees(state, employees){
        state.employees = employees
    },
    add_employee(state, value){
        state.employees.push(value);
    },
    set_active_employee(state,value) {
        state.activeEmployee = value;
    },
    clear_store(state) {
        state.employees = [];
        mutations.clear_active_employee(state);
    },
    clear_active_employee(state) {
        state.activeEmployee = {
            id: null,
            name: '',
            first_name:'',
            patronymic:'',
            tel_number:'',
            email:'',
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
