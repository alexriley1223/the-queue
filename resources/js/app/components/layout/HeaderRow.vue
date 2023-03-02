<template>
    <header class="absolute top-0 w-full" :class="(isMobileOpen) ? 'bg-black' : ''">
        <!-- Desktop -->
        <ul class="text-white justify-between items-center px-4 mt-4 [&>li>a]:hover:cursor-pointer hidden md:flex">
            <div class="space-x-4 flex items-center py-2">
                <li><router-link to="/">Home</router-link></li>
                
                <Transition>
                    <li v-if="isAuthenticated"><router-link to="/profile">Profile</router-link></li>
                </Transition>

                <Transition>
                    <li v-if="isAuthenticated"><a class="hover:cursor-pointer" @click="logout">Logout</a></li>
                </Transition>

                <Transition>
                    <li v-if="!isAuthenticated"><a @click="login()" class="flex items-center cursor-pointer bg-[#1DB954] hover:bg-[#158a3f] transition-colors rounded-md px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-spotify mr-2" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.669 11.538a.498.498 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686zm.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858zm.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288z"/>
                            </svg>
                            Login with Spotify
                        </a>
                    </li>
                </Transition>

            </div>
    
            <room-code></room-code>
        </ul>

        <!-- Mobile -->
        <ul class="flex md:hidden items-center px-2 mt-2 z-30 absolute w-full" :class="room ? 'justify-between' : 'justify-end'">
            <room-code></room-code>

            <div @click="toggleMobile()" class="px-3 py-2 space-y-2 rounded cursor-pointer transition-colors" :class="(isMobileOpen) ? 'bg-black' : ''">
                <span class="block w-8 h-0.5 bg-white"></span>
                <span class="block w-8 h-0.5 bg-white"></span>
                <span class="block w-8 h-0.5 bg-white"></span>
            </div>
        </ul>

        <!-- Mobile Drop -->
        <Transition>
            <div v-if="isMobileOpen" class="absolute top-0 bg-white opacity-95 w-screen h-screen z-20 md:hidden">
                <ul class="pt-20 h-full px-4 font-bold uppercase text-4xl relative">
                    <li class="w-full mb-4"><router-link class="block w-full underline" to="/">Home</router-link></li>
                    <li v-if="!isAuthenticated" class="absolute bottom-0 w-full left-0"><a @click="login()" class="flex items-center cursor-pointer bg-[#1DB954] hover:bg-[#158a3f] transition-colors px-3 py-7 text-3xl justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-spotify mr-2" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.669 11.538a.498.498 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686zm.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858zm.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288z"/>
                            </svg>
                            Login with Spotify
                        </a>
                    </li>
                    <li class="absolute bottom-0 w-full left-0" v-if="isAuthenticated">
                        <a class="flex justify-center bg-black text-white cursor-pointer px-3 py-7 text-3xl" @click="logout">Logout</a>
                    </li>
                    <li class="w-full" v-if="isAuthenticated"><router-link class="block w-full underline" to="/profile">Profile</router-link></li>
                    
                </ul>
            </div>
        </Transition>
    </header>
</template>

<style>
    .v-enter-active,
    .v-leave-active {
    transition: opacity 0.5s ease;
    }

    .v-enter-from,
    .v-leave-to {
    opacity: 0;
    }
</style>
<script>
import RoomCode from "./RoomCode.vue";

export default {
    name: "HeaderRow",

    data() {
        return {
            user: this.$store.state.auth.user,
            isMobileOpen: false
        }
    },

    components: {
        RoomCode
    },

    methods: {
        async logout(){
            await axios.post('/api/auth/logout').then(({ data })=>{
                this.$store.dispatch('auth/logout')
                this.$router.push({ name:"home" });
            });
        },
        redirect(route) {
            this.$router.push({ name: route })
        },

        async login() {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/auth/login',this.auth).then(({ data })=>{
                window.location.href = data;
            });
        },

        toggleMobile() {
            this.isMobileOpen = !this.isMobileOpen;
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