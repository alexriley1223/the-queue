<template>
    <base-layout>
        <div class="w-full h-full flex flex-col justify-center items-center">

            <div class="text-white">
                <img class="rounded-full w-60 h-60 object-cover mb-2 border border-white" :src="user['avatar']" :alt="user['name'] + ' Avatar'">

                <p class="text-center text-xl mb-4">{{ user['name'] }} • {{ user['code'] }}</p>

                <p class="text-center hover:cursor-pointer text-xs" @click="testProfile">Click to Test API: <span>{{ apiStatus }}</span></p>
            </div>
        </div>
    </base-layout>
</template>
<script>
import BaseLayout from "../layout/BaseLayout.vue";

export default {
    
    data(){
        return {
            user: this.$store.state.auth.user.user,
            apiStatus: 'N/A'
        }
    },

    components: {
            BaseLayout
    },

    methods:{
        async logout(){
            await axios.post('/api/auth/logout').then(({ data })=>{
                this.$store.dispatch('auth/logout')
                this.$router.push({ name:"login" });
            });
        },
        async testProfile() {
            return axios.get('/api/me').then(({ data })=>{ this.apiStatus = 'Working!' }).catch(({ response })=>{ this.apiStatus = 'Not Working!' });
        }
    }
}
</script>