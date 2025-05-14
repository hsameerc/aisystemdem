<template>
  <div class="layout-simple">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'SimplePage',
  created() {
    console.log('MainPage Created.')
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
