<template>
    <base-layout>
        <template v-slot:default>
            <section class="w-full h-full flex justify-center items-center">
                <div>
                    <h1 class="text-white text-center font-bold">THE <span>QUEUE</span></h1>
                    <input type="text" placeholder="Search a song" v-model="searchQuery">
                    <input @click="handleSearch" type="submit" value="Submit">
                </div>
            </section>
        </template>
    </base-layout>
</template>

<script>
    import BaseLayout from "../layout/BaseLayout.vue";
    export default {
        name: "Home",
        data() {
            return {
                searchQuery: ''
            }
        },
        components: {
            BaseLayout
        },

        methods: {
            handleSearch() {
                this.$router.push({ name: 'search', query: { q: this.searchQuery }})
            }
        }
    }
</script>