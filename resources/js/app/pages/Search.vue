<template>
    <base-layout>
        <template v-slot:default>

            <div class="w-full text-white">

                <div class="flex flex-col justify-center mt-32 w-full">
                    <section class="text-center mb-4">
                        <h1 class="font-serif text-4xl mb-4">Track Results</h1>
                        <p class="border w-32 mx-auto py-2 bg-white text-black select-none">{{ query }}</p>
                    </section>

                    <TransitionGroup tag="div" :css="false" @before-enter="onBeforeEnter" @enter="onEnter" @leave="onLeave" class="grid grid-cols-3 gap-2">
                        <div @click="addTrack(track.id)" class="hover:cursor-pointer" v-for="track in tracks" :key="track.id">
                            <img class="" :src="track.image" :alt="track.track + ' Image'">
                            <div>
                                <p>{{ track.track }}</p>
                                <p><small>{{ track.artist }}</small></p>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>
            </div>
            
        </template>
    </base-layout>
</template>

<script>
import BaseLayout from "../layout/BaseLayout.vue";

export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            query: this.$route.query.q,
            loading: true,
            tracks: []
        }
    },

    components: {
        BaseLayout
    },

    methods: {
        async search() {
            await axios.post('/api/spotify/public/search', { q: this.query }).then(({ data })=>{
                this.tracks = data;
            }).catch(({response})=>{
                console.log(response);
            });
        },

        onBeforeEnter(el) {
            el.style.opacity = 0
            el.style.height = 0
        },
        onEnter(el, done) {
            gsap.to(el, {
                opacity: 1,
                height: '575px',
                delay: el.dataset.index * 0.25,
                onComplete: done
            })
        },
        onLeave() {},

        async addTrack(id) {
            let track = this.tracks.find(x => x.id === id);

            await axios.post('/add', { code: this.room, track: { name: track.track, uri: track.id, artist: track.artist, image: track.image, image_thumb: track.image_thumb }}, { headers: { 'X-CSRF-TOKEN': this.csrf }}).then(({ data })=>{
                console.log(data);
            }).catch(({response})=>{
                console.log(response);
            });
        }
    },

    computed: {
        room() {
            return this.$store.getters['guest/room'];
        }
    },

    mounted() {
        if(!this.$store.state.guest.room) { this.$router.push({ path: '/', replace: true }) }
        if(!this.query) { this.$router.push({ path: '/', replace: true }) } else { this.search(); }
    }
}

</script>