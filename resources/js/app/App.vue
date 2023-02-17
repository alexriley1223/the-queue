<template>
    <router-view />
</template>

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
                }
                return Promise.reject(error)
            }
        )
    }
}
</script>