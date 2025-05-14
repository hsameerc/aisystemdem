<template>
    <main class="col-lg-8 offset-lg-2 mt-4">
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <router-link to="/app/models" class="navbar-brand">Models</router-link>
                <button class="btn btn-lg btn-light fw-bold border-white " @click="showAddModel()" v-if="listModel"><i
                    class="bi-plus"></i>
                    Add Modal
                </button>
                <button class="btn btn-lg btn-light fw-bold border-white " @click="showListModel()" v-if="addModel"><i
                    class="bi-list"></i>
                    List Modals
                </button>
            </div>
        </div>
        <add-models v-if="addModel"></add-models>
        <list-models v-if="listModel"></list-models>
    </main>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ListModels from "@/components/partials/ListModels.vue";
import AddModels from "@/components/partials/AddModal.vue";

export default {
    name: 'MyModels',
    data() {
        return {
            listModel: true,
            addModel: false,
        };
    },
    components: {AddModels, ListModels},
    computed: {
        ...mapGetters('user', ['getToken']),
        ...mapGetters('model', ['getModels']),
    },
    created() {
        this.fetchModal()
    },
    methods: {
        ...mapActions('model', ['httpGetModels',]),
        async fetchModal() {
            await this.httpGetModels('')
        },
        showAddModel() {
            this.listModel = false
            this.addModel = true

        },
        showListModel() {
            this.listModel = true
            this.addModel = false
            this.fetchModal()
        }
    },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
