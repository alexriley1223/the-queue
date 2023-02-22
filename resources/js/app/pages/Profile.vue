<template>
    <base-layout>
        <template v-slot:default>
            <div class="w-full pt-32">

                <section class="text-white mb-12">

                    <img class="rounded-full w-48 h-48 object-cover mx-auto border-2 border-white" :src="user['avatar']">

                    <p class="text-center text-xl mb-4">{{ user['name'] }} • {{ user['code'] }}</p>
                </section>

                <queue></queue>
            </div>
        </template>
    </base-layout>
</template>
<script>
import BaseLayout from "../layout/BaseLayout.vue";
import Queue from "../components/profile/Queue.vue";

export default {
    
    data(){
        return {
            user: this.$store.state.auth.user.user,
            apiStatus: 'N/A'
        }
    },

    components: {
        BaseLayout,
        Queue
    },

    methods:{
        async logout(){
            await axios.post('/api/auth/logout').then(({ data })=>{
                this.$store.dispatch('auth/logout')
                this.$router.push({ name:"login" });
            });
        }
    }
}
</script>