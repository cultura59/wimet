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
        espacio: {categorias: []},
        categoriesSelected: [],
        categories: [],
        categorySelected: {}
    },
    getters: {
        getUser: state => {
            return state.user;
        },
        getEspacio: state => {
            return state.espacio;
        },
        getCategoriesSelected: state => {
            return state.categoriesSelected;
        },
        getCategories: state => {
            return state.categories;
        },
        getCategorySelected: state => {
            return state.categorySelected;
        }
    },
    mutations: {
        setUser(state, user) {
            state.user =  user;
        },
        setEspacio(state, espacio) {
            state.espacio = espacio;
        },
        setCategoriesSelected(state, categories) {
            state.categoriesSelected = [];
            state.categoriesSelected = categories;
        },
        clearInfo(state) {
            state.user = {};
        },
        setCategories(state, categories) {
            state.categories = categories;
        },
        setCategorySelected(state, category) {
            state.categorySelected = category;
        }
    },
    plugins: [vuexLocalStorage.plugin]
});