import { createRouter, createWebHistory } from "vue-router";
import store from '../store/index';

import Home from '../pages/Home.vue';
import Search from '../pages/Search.vue';
import Profile from '../pages/Profile.vue';
import LoginCallback from '../pages/auth/LoginCallback.vue';

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        meta: {
            middleware: "public",
            title: `The Queue`
        }
    },
    {
        name: 'search',
        path: '/search',
        props: true,
        component: Search,
        meta: {
            middleware: "public",
            title: `Search`
        }
    },
    {
        name: 'logincallback',
        path: '/login/callback',
        component: LoginCallback,
        meta: {
            middleware: "guest",
            title: `Login Callback`
        }
    },
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
        meta: {
            middleware: "auth",
            title: `Profile`
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "profile" })
        }
        next()
    } else if (to.meta.middleware == "public") {
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