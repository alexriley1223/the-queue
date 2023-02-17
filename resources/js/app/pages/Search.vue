<template>
    <div>
        <h2 class="text-center">Search Results</h2>
        <TransitionGroup tag="div" :css="false" @before-enter="onBeforeEnter" @enter="onEnter" @leave="onLeave" class="flex flex-col space-y-4 items-center">
            <div class="w-80" v-for="track in tracks" :key="track.id">
                <img :src="track.image" :alt="track.track + ' Image'">
                <div>
                    <p>{{ track.track }}</p>
                    <p><small>{{ track.artist }}</small></p>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            query: '',
            loading: true,
            tracks: []
        }
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
                height: '368px',
                delay: el.dataset.index * 0.25,
                onComplete: done
            })
        },
        onLeave() {}
    },

    mounted() {
        this.query = this.$route.query.q;
        this.search();
    }
}

</script>