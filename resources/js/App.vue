<template>
    <default-page></default-page>
</template>

<script>
import DefaultPage from "@/components/layouts/Default.vue";
import ApiService from "@/services/api";
import {mapGetters} from "vuex";

export default {
    name: 'App',
    props: ['route'],
    components: {
        DefaultPage,
    },
    data() {
        return {
            loaded: true,
        }
    },
    beforeCreate() {
    },
    created() {
        if (this.isLoggedIn) {
            ApiService.init(this.token);
        }
    },
    computed: {
        ...mapGetters('user', ['isLoggedIn'])
    },
    methods: {

    }
}
</script>

<style>
a {
    text-decoration: none;
    text-transform: uppercase;
}
button {

}
</style>
