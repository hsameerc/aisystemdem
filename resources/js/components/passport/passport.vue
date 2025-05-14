<template>

    <main class="col-lg-8 offset-lg-2 mt-4">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <router-link to="/app/my-passport" class="navbar-brand">My passport</router-link>
<!--                <router-link to="/app/my-passport" class="navbar-brand">My passport</router-link>-->
<!--                <router-link to="/app/my-passport" class="navbar-brand">My passport</router-link>-->
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid mt-5">
            <div class="row">
                <clients></clients>
<!--                <personal-access-tokens></personal-access-tokens>-->
<!--                <authorized-clients></authorized-clients>-->
            </div>
        </div>
    </main>
</template>
<script>
import Clients from "@/components/passport/Clients.vue";
import AuthorizedClients from "@/components/passport/AuthorizedClients.vue";
import PersonalAccessTokens from "@/components/passport/PersonalAccessTokens.vue";

export default {
    name: 'Passport',
    components: {
        Clients,
        AuthorizedClients,
        PersonalAccessTokens,
    },
    data() {
        return {};
    },
}
</script>
