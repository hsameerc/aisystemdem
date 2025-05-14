<template>
  <footer class="bg-light mt-5 mh-100">
    <div class="text-center p-3 mt-auto footer-copyright">
       <span>
         © 2023 Copyright
        <a href="https://hsameer.com.np/" target="_blank">hsameer.com.np</a>
       </span>
    </div>
  </footer>
</template>

<script>
export default {
  name: "MainFooter"
  // You can add any logic related to the footer here if needed
};
</script>

<style>
.footer-copyright{
  font-size: 14px;
}
.footer-copyright a{
  text-decoration: none;
  text-transform: lowercase;
}
</style>