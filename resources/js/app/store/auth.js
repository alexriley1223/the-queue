import axios from 'axios';
import router from '../router/index';

export default {
    namespaced: true,
    state:{
        authenticated: false,
        user: {}
    },
    getters:{
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
    },
    actions:{
        login({ commit }, userData){
            commit('SET_USER', userData)
            commit('SET_AUTHENTICATED', true)
            axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`;
        },
        logout({ commit }){
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
        }
    }
}