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
        token: {
            token: '',
            exppiration: ''
        }
    },
    getters: {
        getUser: state => {
            return state.user;
        },
        getToken: state => {
            if(state.token.token == '' || state.token.exppiration == '') {
                return null;
            }
            if(Date.now() > parseInt(state.token.exppiration)) {
                state.token.token = '';
                state.token.exppiration = '';
                state.user = {};
                return null;
            }else {
                return state.token;
            }
        }
    },
    mutations: {
        setUser(state, user) {
            state.user =  user;
        },
        setToken(state, token, exppiration) {
              state.token = {
                  token: token,
                  exppiration: exppiration
              };
        },
        clearInfo(state) {
            state.user = {};
            state.token = {
                token: '',
                exppiration: ''
            }
        }
    },
    plugins: [vuexLocalStorage.plugin]
});