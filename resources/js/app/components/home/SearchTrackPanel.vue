<template>
    <div class="w-full text-center">

        <form @submit="handleSearch($event)" class="w-full">

            <label for="search" class="sr-only">Track Search</label>

            <div class="relative w-[50%] mx-auto">
                <input v-model="search" type="text" name="search" class="text-white w-full bg-transparent border-2 px-4 py-2 placeholder:text-white border-white rounded-sm" placeholder="Search a track">
                <button type="submit" class="absolute right-0 bottom-0 h-full w-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="bi bi-search fill-white mx-auto" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>

        </form>

    </div>
</template>

<script>
    export default {
        name: "SearchCodePanel",

        data() {
            return {
                search: ''
            }
        },

        methods: {
            handleSearch(e) {
                e.preventDefault();
                
                this.$emit('searchTrack', this.search);
            }
        },
    };
</script>