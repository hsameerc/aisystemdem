<template>
  <header class="mb-auto">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand"><i class="bi-menu-down"></i></router-link>
        <button class="navbar-toggler" type="button" @click="toggleMenu">
          <i class="bi-menu-app"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" :class="{ 'show': isMenuOpen }">
          <ul class="navbar-nav ml-auto" :class="{ 'active': isMenuOpen }">
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link to="/" class="nav-link"><i class="bi-app-indicator"></i> Home</router-link>
            </li>
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link to="/login" class="nav-link">Login</router-link>
            </li>
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link to="/register" class="nav-link">Register</router-link>
            </li>

            <li class="nav-item nav-dashboard" v-if="isLoggedIn">
              <router-link to="/my-dashboard" class="nav-link"><i class="bi-house"></i> Dashboard</router-link>
            </li>
            <li><a href="#" class="nav-link" @click="logOut()" v-if="isLoggedIn">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

  </header>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

export default {
  name: "MainHeader",
  data() {
    return {
      isMenuOpen: false,
    };
  },
  methods: {
    ...mapActions('user', ['httpLogout']),
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    async logOut() {
      try {
        const credentials = {}
        await this.httpLogout(credentials);
        this.redirectToLogin();
      } catch (error) {
        this.errors.status = true;
        this.errors.message = error.message;
      }
    },
    redirectToLogin() {
      this.$router.push('/login');
    },
  },
  computed: {
    ...mapGetters('user', {
      isLoggedIn: 'isLoggedIn'
    }),
  },
};
</script>

<style>
.nav-link {
  color: #2a2a2a;
  font-size: 18px !important;
}

.nav-link.router-link-active {
  color: var(--bs-primary)
}

</style>