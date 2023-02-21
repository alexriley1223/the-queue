<template>
    <div>
      <header-row></header-row>
      <main>
        <slot></slot>
      </main>
      <footer-row></footer-row>
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