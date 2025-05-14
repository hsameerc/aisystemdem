<template>
    <div class="cover-container d-flex mx-auto flex-column">
        <!--    <main-header></main-header>-->
        <home-page v-if="layout === 'home'"></home-page>
        <main-page v-else-if="layout==='user-layout'"></main-page>
<!--        <simple-page v-else></simple-page> -->
        <home-page v-else></home-page>
        <!--    <main-footer></main-footer>-->
    </div>
</template>

<script>
import MainPage from "@/components/layouts/Page.vue";
import HomePage from "@/components/layouts/Home.vue";
import SimplePage from "@/components/layouts/Simple.vue";
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'DefaultPage',
    components: {SimplePage, HomePage, MainPage},
    computed: {
        ...mapGetters('user', ['isLoggedIn']),
        layout() {
            return this.$route.meta.layout;
        }
    },
    created() {
        if(!this.isLoggedIn){
            this.httpMe()
        }else{
            this.setMeDefaults()
        }
    },
    methods: {
        ...mapActions('user', ['httpMe', 'setMeDefaults']),
    }
}
</script>

<style scoped>

</style>
