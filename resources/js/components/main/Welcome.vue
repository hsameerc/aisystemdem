<template>
  <main class="px-3 col-md-8 offset-md-2 col-sm-12 mt-4">
    <h1>Unleash the Power of AI for Your Business with Fine-Tuned  <span class="text-primary">OPEN AI Models</span>!</h1>
    <p class="lead"> Enhanced Performance: Witness a significant boost in the performance of your AI applications. </p>
    <p class="lead"> Fine-tuning allows for improved predictions, enhanced natural language understanding, and better decision-making capabilities. </p>
    <p>
      <router-link to="/app" class="btn btn-lg btn-light fw-bold border-white">Dashboard</router-link>
    </p>
  </main>
</template>

<script>
export default {
  name: 'WelcomePage',
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
</style>
