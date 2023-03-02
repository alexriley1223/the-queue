<template>
    <base-layout>
        <template v-slot:default>
            
            <div class="w-screen h-screen bg-home-background bg-cover bg-no-repeat bg-center">
                <div class="flex flex-col justify-center items-center h-[75%] w-full">
                    <h1 class="uppercase text-4xl md:text-6xl lg:text-8xl mb-14 pt-4 pb-8 border-b-2 border-t-2 font-bold font-serif tracking-wider text-white select-none">The Queue</h1>

                    <Transition>
                        <room-code-panel v-if="step == 'roomcode'" @handleStepChange="step = 'search'"></room-code-panel>
                    </Transition>

                    <Transition>
                        <search-track-panel v-if="step == 'search'" @searchTrack="handleSearch($event)"></search-track-panel>
                    </Transition>
                </div>
            </div>
            
        </template>
    </base-layout>
</template>

<style>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.25s ease-in-out;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
</style>

<script>
    import BaseLayout from "../layout/BaseLayout.vue";

    import RoomCodePanel from "../components/home/RoomCodePanel.vue";
    import SearchTrackPanel from "../components/home/SearchTrackPanel.vue";

    export default {
        name: "Home",

        components: {
            BaseLayout,
            RoomCodePanel,
            SearchTrackPanel
        },

        methods: {
            handleStepChange() {
                this.step == 'search';
            },
            handleSearch(query) {
                this.$router.push({ name: 'search', query: { q: query }})
            }
        },

        computed: {
            step() {
                return this.$store.getters['guest/room'] ? 'search' : 'roomcode';
            }
        }
    }
</script>