<template>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg text-start">
                    <div class="card-body">
                        <div class="spinner-border text-primary" role="status" v-if="loading">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <ul class="list-group list-group-flush" v-if="getLoaded && getModels.results.length">
                            <li class=" list-group-item d-flex justify-content-between"
                                v-for="model in getModels.results"
                                :key="model.id">
                                <router-link :to="`/app/models/${model.id}`">
                                    <div class="model-info">
                                        <p class="mb-0 lead fw-bold">Name: {{ model.name }}</p>
                                        <p class="mb-0"><span class="fw-bold">ID:</span> {{ model.id }}</p>
                                        <p class="mb-0"><span class="fw-bold">CREATED:</span> {{ model.created }}</p>
                                    </div>
                                </router-link>
                                <div>
                                    <router-link :to="`/app/models/${model.id}`"
                                                 class="btn btn-md btn-light fw-bold border-primary bg-white"><i
                                        class="bi-eye"></i></router-link>
                                </div>
                            </li>
                        </ul>
                        <p v-else>No recent models.</p>
                    </div>
                    <div class="card-footer bg-light text-center">
                        <default-pagination :next="getModels.next" :previous="getModels.previous"
                                            :count="getModels.count"
                                            @page-changed="fetchData"></default-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import DefaultPagination from "@/components/partials/Pagination.vue";
import SpinnerLoader from "../LoaderComponent.vue";

export default {
    name: 'ListModels',
    components: {SpinnerLoader, DefaultPagination},
    data() {
        return {
            loading: false
        }
    },
    computed: {
        ...mapGetters('model', ['getModels', 'getLoaded']),
    },
    created() {
        this.loading = !this.getLoaded;
    },
    methods: {
        ...mapActions('model', ['httpGetModels',]),
        async fetchData(page) {
            this.loading = true
            const urlParams = this.extractQueryParams(page);
            await this.httpGetModels(urlParams)
            this.loading = false
        },
        extractQueryParams(page) {
            const queryString = page;
            const queryParams = queryString.split('?');
            return '?' + queryParams[1] ?? null;
        },
    },
    watch: {
        getLoaded() {
            if (this.getLoaded) {
                this.loading = false
            }
            return this.getLoaded
        }
    }
}
</script>

<style scoped>
.spinner-border {
    z-index: 999;
    position: absolute;
    top: 50%;
    left: 50%;
}
.list-group-item{
    margin-bottom: 10px;
    border-bottom: none;
}
</style>
