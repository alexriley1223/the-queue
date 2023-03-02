<template>
    <div class="flex items-center justify-center h-screen">
        <div
            class="inline-block h-64 w-64 animate-spin rounded-full border-4 text-white border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
            role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap text-white !border-0 !p-0 ![clip:rect(0,0,0,0)]"></span>
        </div>
        <p class="text-white absolute text-xl font-bold left-1/2 translate-x-[-50%]">Authenticating</p>
    </div>
</template>
<script>
import { mapActions } from 'vuex';

export default {
    name: "logincallback",
    data(){
        return {
            
        }
    },
    methods:{
        ...mapActions({
            signIn: 'auth/login'
        }),
        async validateToken() {
            let queryCode = this.$route.query.code;
            let queryState = this.$route.query.state;
            
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/auth/callback', { code: queryCode, state: queryState }).then(({ data })=>{
                try {
                    this.signIn(data);
                } catch (error) {
                    console.log(error);
                }
                
                this.$router.push({ path: '/profile', replace: true });
            }).catch(({response})=>{
                // TODO: Set error flag so it's apparent to the user the login failed
                console.log(response);
                this.$router.push({ path: '/login', replace: true });
            });
        }
    },
    mounted() {
        if (this.$route.query.error) {}
        if (!this.$route.query.code) { this.$router.push({ path: '/login', replace: true }) }
        this.validateToken();
    }
}
</script>