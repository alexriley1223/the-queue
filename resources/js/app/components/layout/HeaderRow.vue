<template>
    <header>
        <ul class="text-white flex justify-between px-4 mt-4 [&>li>a]:hover:cursor-pointer">
            <div class="space-x-4 flex">
                <li><router-link to="/">Home</router-link></li>
                <li v-if="isAuthenticated"><router-link to="/profile">Profile</router-link></li>
                <li v-if="isAuthenticated"><a @click="logout">Logout</a></li>
                
                <li v-if="!isAuthenticated"><router-link to="/login">Profile</router-link></li>
            </div>
            

            <p v-if="room" class="bg-gray-800 rounded-md px-4 py-1"><span class="text-xs" @click="removeCode">(X)</span> {{ room }}</p>
        </ul>
    </header>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: "HeaderRow",

    data() {
        return {
            user: this.$store.state.auth.user,
        }
    },

    methods: {
        ...mapActions({
            removeCode: 'guest/remove'
        }),
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
        },

        room() {
            return this.$store.getters['guest/room'];
        }
    }
};
</script>