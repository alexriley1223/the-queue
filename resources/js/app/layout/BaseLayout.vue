<template>
    <div class="w-screen h-screen bg-black flex flex-col">
      <header-row></header-row>
      <main class="flex-1">
        <slot></slot>
      </main>
      <footer-row class="flex-shrink"></footer-row>
    </div>
</template>
  
<script>
    import HeaderRow from "../components/layout/HeaderRow.vue";
    import FooterRow from "../components/layout/FooterRow.vue";
    export default {
        name: "BaseLayout",
        components: {
            HeaderRow,
            FooterRow
        }
    };
</script>