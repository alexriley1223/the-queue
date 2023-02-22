<template>
    <div>
        <p class="text-white hover:cursor-pointer" @click="login">Login</p>
    </div>
</template>
<script>
export default {
    name: "login",
    data(){
        return {
            processing: false,
        }
    },
    methods:{
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/auth/login',this.auth).then(({ data })=>{
                window.location.href = data;
            }).catch(({response})=>{
                
            });
        },
    }
}
</script>