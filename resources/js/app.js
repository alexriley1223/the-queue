import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import App from './app/App.vue';
import router from './app/router/index';
import store from './app/store/index';

const app = createApp({
    components: {
        App,
    }
});

app.use(router);
app.use(store);
app.mount('#app');