<template>
    <div class="w-full text-center">

        <form @submit="setCode($event)" class="w-full">

            <label for="code" class="sr-only">Room Code</label>

            <div class="relative w-[95%] md:w-[50%] lg:w-[25%] mx-auto">
                <input v-model="code" type="text" name="code" class="text-white w-full bg-transparent border-2 px-4 py-2 placeholder:text-white border-white rounded-sm" placeholder="Enter room code">
                <button type="submit" class="absolute right-0 bottom-0 h-full w-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="bi bi-person-up fill-white mx-auto" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.354-5.854 1.5 1.5a.5.5 0 0 1-.708.708L13 11.707V14.5a.5.5 0 0 1-1 0v-2.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                    </svg>
                </button>
            </div>
            
        </form>

    </div>
</template>

<script>
import { mapActions } from 'vuex';

    export default {
        name: "RoomCodePanel",

        data() {
            return {
                code: ''
            }
        },

        methods: {
            ...mapActions({
                storeCode: 'guest/add',
            }),
            async setCode(e) {
                e.preventDefault();
            
                await axios.post('/api/code/verify', { code: this.code }).then(({ data })=>{
                    console.log(data.code);
                    if(data.code) {
                        this.code = data.code;
                        this.storeCode(data.code);
                        this.$emit('handleStepChange', true);
                    }
                }).catch(({ response })=>{
                    // TODO: Show an error here that a code wasn't found
                    console.log(response);
                });;
            }
        }
    };
</script>