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
            let that = this;
            
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/auth/callback', { code: queryCode, state: queryState }).then(({ data })=>{
                try {
                    that.signIn(data);
                } catch (error) {
                    console.log(error);
                }
                
                that.$router.push({ path: '/profile', replace: true });
            }).catch(({response})=>{
                // Show error messages, set error flag
                console.log('Error');
                console.log(response);
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