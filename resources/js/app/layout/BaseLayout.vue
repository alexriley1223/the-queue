<template>
    <div>
      <header-row class="z-30"></header-row>
      <main class="z-20">
        <slot></slot>
      </main>
      <footer-row class="z-10"></footer-row>
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