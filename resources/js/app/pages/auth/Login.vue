<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Login</h1>
                        <hr/>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
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