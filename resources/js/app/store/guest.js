export default {
    namespaced: true,
    state:{
        room: null
    },
    getters:{
        room(state) {
            return state.room
        }
    },
    mutations:{
        SET_ROOM (state, value) {
            state.room = value
        },
    },
    actions:{
        add({ commit }, roomCode){
            commit('SET_ROOM', roomCode)
        },
        remove({ commit }){
            commit('SET_ROOM', null)
        }
    }
}