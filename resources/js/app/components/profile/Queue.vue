<template>
    <section class="text-white">
        <p class="text-2xl font-semibold font-serif tracking-wider text-center">My Queue</p>

        <transition name="fade">
            <div v-if="notice.content" class="my-6 font-bold w-11/12 lg:w-fit mx-auto text-center">
                <p v-if="notice.type == 'error'" class="border-2 border-l-green-500 border-t-0 border-b-0 border-r-green-500 px-6">{{ notice.content }}</p>
                <p v-if="notice.type == 'success'" class="border-2 border-l-green-500 border-t-0 border-b-0 border-r-green-500 px-6">{{ notice.content }}</p>
            </div>
        </transition>

        <transition-group name="list" tag="div" class="flex flex-col relative">
            <div v-for="(track, index) in queue" :key="track" class="flex flex-col lg:flex-row mx-auto w-11/12 lg:w-3/4 items-center justify-between py-6 border-b-2 border-white last:border-0">

                <div class="flex flex-col lg:flex-row items-center mb-4 lg:mb-0 w-full lg:w-auto">
                    <img class="w-32 rounded-full border-2 border-white mb-4 lg:mb-0" :src="track.image" :alt="track.name">

                    <div class="flex flex-col lg:ml-4 text-center lg:text-left">
                        <p class="font-serif">{{ track.name }}</p>
                        <p>By {{ track.artist }}</p>
                    </div>
                </div>
                

                <div class="flex flex-row lg:flex-col items-center space-x-2 lg:space-y-2 lg:space-x-0 w-full lg:w-auto">
                    <button @click="addTrack(track.id, index)" class="border-2 border-white transition-colors hover:bg-white hover:text-black rounded-sm h-12 w-1/2 lg:w-32 flex items-center justify-center">Add <span class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </span>
                    </button>
                    <button @click="removeTrack(track.id, index)" class="bg-white text-black transition-colors hover:bg-black hover:text-white hover:border-white border-2 border-transparent rounded-sm h-12 w-1/2 lg:w-32 flex items-center justify-center">Remove <span class="ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </transition-group>
    </section>
</template>

<style>
.list-enter-active,
.list-leave-active,
.list-move {
  transition: 500ms cubic-bezier(0.59, 0.12, 0.34, 0.95);
  transition-property: opacity, transform;
}

.list-enter {
  opacity: 0;
  transform: translateX(50px) scaleY(0.5);
}

.list-enter-to {
  opacity: 1;
  transform: translateX(0) scaleY(1);
}

.list-leave-active {
  position: absolute;
}

.list-leave-to {
  opacity: 0;
  transform: scaleY(0);
  transform-origin: center top;
}


.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0
}
</style>

<script>

export default {
    
    data() {
        return {
            queue: [],
            notice: {
                type: '',
                content: ''
            }
        }
    },

    methods: {
        async addTrack(id, index) {
            await axios.post('/api/user/queue/add', { id: id })
            .then(({ data }) => { 
                this.queue.splice(index, 1);
                this.notice.type = 'success';
                this.notice.content = 'Track added to Spotify queue.';
            })
            .catch(({ response }) =>{ 
                this.hasError = true;
            });
        },

        async removeTrack(id, index) {
            await axios.post('/api/user/queue/remove', { id: id })
            .then(({ data })=>{ 
                this.queue.splice(index, 1);
                this.notice.type = 'success';
                this.notice.content = 'Track removed from your queue.';
            }).
            catch(({ response })=>{ 
                this.notice.type = 'error';
                this.notice.content = 'Unable to add track. Please try again.';
            });
        }
    },
    mounted() {
        // TODO: Error handling
        axios.get('/api/user/queue').then(({ data })=>{ this.queue = data }).catch(({ response })=>{ console.log(response) });
    },
}

</script>