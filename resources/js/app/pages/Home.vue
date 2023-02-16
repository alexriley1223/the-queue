<template>
    <base-layout>
        <template v-slot:default>
            <div>
                :O
            </div>
        </template>
    </base-layout>
</template>

<script>
    import BaseLayout from "../layout/BaseLayout.vue";
    export default {
        name: "Home",
        components: {
            BaseLayout
        }
    }
</script>