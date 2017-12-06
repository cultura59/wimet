import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';

Vue.use(Vuex);

// Configuracion para guardar los stores en el localStorage
const vuexLocalStorage = new VuexPersist({
    key: 'sWimet',
    storage: window.localStorage
});

// Se configuran variables/states, getters y setters
export const store = new Vuex.Store({
    state: {
        user: null,
        categoriesSelected: []
    },
    getters: {
        getUser: state => {
            return state.user;
        },
        getCategoriesSelected: state => {
            return state.categoriesSelected;
        }
    },
    mutations: {
        setUser(state, user) {
            state.user =  user;
        },
        setCategoriesSelected(state, categories) {
            state.categoriesSelected = [];
            state.categoriesSelected = categories;
        },
        clearInfo(state) {
            state.user = {};
        }
    },
    plugins: [vuexLocalStorage.plugin]
});