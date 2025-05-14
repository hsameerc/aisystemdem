<template>
    <main class="col-lg-8 offset-lg-2 mt-4">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <router-link to="/app" class="navbar-brand">Dashboard</router-link>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-4">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Welcome, {{ getUser.username }}!</h5>
                            <p class="card-text">Email: {{ getUser.email }}</p>
                        </div>
                    </div>
                    <button class="btn btn-lg btn-light fw-bold border-white bg-light w-100 mb-3" @click="allModels()">
                        Models
                    </button>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-lg text-start">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="model-info bg-primary text-white p-2 text-center border">
                                        <i class="bi-check-circle fs-2"></i>
                                        <h2 class="mb-0">1000</h2>
                                        <p>Models</p>
                                    </div>
                                </div>
                                <div class="col-md-6  mb-3">
                                    <div class="model-info bg-secondary text-white p-2 text-center border">
                                        <i class="bi-check-circle fs-2"></i>
                                        <h2 class="mb-0">1000</h2>
                                        <p>Support Data</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
export default {
    name: 'MyDashboard',
    components: {
    },
    data() {
        return {
            user: {},
        };
    },
    created() {
        this.httpMeStatus()
    },
    computed: {
        ...mapGetters('user', ['getUser']),
    },
    methods: {
        ...mapActions('user', ['httpMeStatus']),
        allModels() {
            this.$router.push('/app/models')
        },
        tokenBuy() {
            this.$router.push('/app/token/manage')
        },
    },
    watch: {},

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.card {
    border: var(--bs-border-width) solid var(--bs-border-color);
}

.model-info {
    border-radius: 10px;
}
</style>
