<template>
    <header>
        <ul class="text-white flex space-x-4 [&>li>a]:hover:cursor-pointer">
            <li><a @click="redirect('home')">Home</a></li>
            <li v-if="isAuthenticated"><a @click="redirect('profile')">Profile</a></li>
            <li v-if="isAuthenticated"><a @click="logout">Logout</a></li>
            <li v-if="!isAuthenticated"><a @click="redirect('login')">Login</a></li>
        </ul>
    </header>
</template>
<script>
export default {
    name: "HeaderRow",

    data() {
        return {
            user: this.$store.state.auth.user
        }
    },

    methods: {
        async logout(){
            await axios.post('/api/auth/logout').then(({ data })=>{
                this.$store.dispatch('auth/logout')
                this.$router.push({ name:"login" });
            });
        },
        redirect(route) {
            this.$router.push({ name: route })
        }
    },
    computed: {
        isAuthenticated() {
            return this.$store.getters['auth/authenticated'];
        }
    }
};
</script>