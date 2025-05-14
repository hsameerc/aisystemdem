<template>
  <div class="layout-page">
    <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: 'MainPage',
  created() {
    console.log('PAGE LAYOUT')
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
