<template>
    <div>

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