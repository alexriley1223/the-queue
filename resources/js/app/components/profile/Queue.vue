<template>
    <section class="text-white">
        <p class="text-center">My Queue</p>

        <div class="flex flex-col space-y-6">
            <div v-for="track in queue" class="flex flex-col mx-auto">

                <div class="flex items-center mb-4">
                    <img class="w-32 rounded-full border-2 border-white" :src="track.image" :alt="track.name">

                    <div class="flex flex-col ml-4">
                        <p class="font-serif">{{ track.name }}</p>
                        <p>By {{ track.artist }}</p>
                    </div>
                </div>
                

                <div class="flex items-center space-x-2">
                    <button @click="addTrack(track.id)" class="border-2 border-white rounded-sm h-12 w-32 flex items-center justify-center">Add <span class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </span>
                    </button>
                    <button @click="removeTrack(track.id)" class="bg-white text-black rounded-sm h-12 w-32 flex items-center justify-center">Remove <span class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

export default {
    
    data() {
        return {
            queue: []
        }
    },

    methods: {
        async addTrack(id) {
            await axios.post('/api/user/queue/add', { id: id })
            .then(({ data }) => { 
                console.log(data);
            })
            .catch(({ response }) =>{ 
                console.log(response);
            });
        },

        async removeTrack(id) {
            await axios.post('/api/user/queue/remove', { id: id })
            .then(({ data })=>{ 
                console.log(data);
            }).
            catch(({ response })=>{ 
                console.log(response);
            });
        }
    },
    mounted() {
        // TODO: Error handling
        axios.get('/api/user/queue').then(({ data })=>{ this.queue = data }).catch(({ response })=>{ console.log(response) });
    },
}

</script>