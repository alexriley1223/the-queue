import { createRouter, createWebHistory } from "vue-router";
import store from '../store/index';

import Home from '../pages/Home.vue';
import Profile from '../pages/Profile.vue';
import Login from '../pages/auth/Login.vue';

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        meta: {
            middleware: "guest",
            title: `Home`
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
        meta: {
            middleware: "auth"
        }
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "profile" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router;