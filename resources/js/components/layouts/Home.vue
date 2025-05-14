<template>
  <div class="layout-home">
    <welcome-page></welcome-page>
  </div>
</template>

<script>

import WelcomePage from "@/components/main/Welcome.vue";

export default {
  name: 'HomePage',
  components: {WelcomePage},
  created() {
    console.log('HOME LAYOUT')
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
