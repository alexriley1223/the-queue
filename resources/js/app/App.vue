<template>
    <router-view v-slot="{ Component }">
        <transition name="page-opacity" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>
</template>

<style>
.page-opacity-enter-active,
.page-opacity-leave-active {
    transition: 500ms ease all;
}

.page-opacity-enter-from,
.page-opacity-leave-to {
    opacity: 0
}
</style>

<script>
export default {
    created () {
        if (this.$store.state.auth.authenticated) {
            axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.auth.user.token}`;
        }

        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response.status === 401) {
                    this.$store.dispatch('auth/logout')
                    this.$router.push({ name:"login" });
                }
                return Promise.reject(error)
            }
        )
    }
}
</script>