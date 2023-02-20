import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

import auth from './auth';
import guest from './guest';

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        guest
    }
})
export default store;