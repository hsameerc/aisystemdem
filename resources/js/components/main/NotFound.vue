<template>
  <transition name="notfound">
    <div class="container-fluid text-center">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card mt-5 card-1 card-still border0">
            <div class="card-body text-uppercase">
              <h1>404</h1>
              <h3 class="mb-4">Oops! Page not Found.</h3>
              <p>We looked everywhere for this page.</p>
              <p>Are you sure the website URL is correct?</p>
              <a href="/app" class="btn btn-lg btn-outline-primary mt-2"><i class="fa fa-home"></i> BACK TO HOME</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  name: 'NotFound',
  created() {
    console.log("NotFound CREATED")
  }
}
</script>


<style scoped>

</style>
