const state = {

    reviews : [],
    activeReview: {
        id: null,
        review: '',
        is_active: false,
        user: null
    },
};
const getters = {
    reviews: (state) => state.reviews,
    activeReview: (state) => state.activeReview
}

const actions = {
    fillReviews({commit}, value){
        commit('fill_reviews', value);
    },
    addReview({commit}, value){
        commit('add_review', value);
    },
    setActiveReview({commit}, value) {
        commit('set_active_review', value);
    },
    clearStore({commit}) {
        commit('clear_store');
    },
    clearActiveReview({commit}) {
        commit('clear_active_review');
    }
};

const mutations = {
    fill_reviews(state, value){
        state.reviews = value

    },
    add_review(state, value){
        state.reviews.push(value);
    },
    set_active_review(state,value) {
        state.activeReview = value;
    },
    clear_store(state) {
        state.reviews = [];
        mutations.clear_active_review(state);
    },
    clear_active_review(state) {
        state.activeReview = {
                id: null,
                review: '',
                is_active: '',
                user: null,
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
