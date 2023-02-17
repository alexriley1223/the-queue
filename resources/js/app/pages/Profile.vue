<template>
    <div>
        <div>
            <p>User Profile</p>
            <span>{{ user }}</span>
            <p @click="testProfile">Click to Test API: <span>{{ apiStatus }}</span></p>
            <img :src="user['avatar']" alt="">
            <p @click="logout">Logout</p>
        </div>
    </div>
</template>
<script>

export default {
    
    data(){
        return {
            user: this.$store.state.auth.user,
            apiStatus: 'N/A'
        }
    },

    methods:{
        async logout(){
            await axios.post('/api/logout').then(({ data })=>{
                this.$store.dispatch('auth/logout')
                this.$router.push({ name:"login" });
            });
        },
        async testProfile() {
            return axios.get('/api/me').then(({data})=>{ this.apiStatus = 'Working!' }).catch(({response})=>{ that.apiStatus = 'Not Working!' });
        }
    }
}
</script>