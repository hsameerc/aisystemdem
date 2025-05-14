<template>
    <div class="card-body">
        <div class="p-3">
            <div class="spinner-grow text-primary" role="status" v-if="!getSelectedLoaded">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="model-detail" v-if="getSelectedLoaded">
                <p class="mb-0"><span class="badge bg-light text-dark">Created On: {{
                    formatDate(getSelectedModel.created)
                }} </span></p>
                <h1 class="mb-0">{{ getSelectedModel.name }}</h1>
                <p class="badge bg-primary text-light ml-2">{{ getSelectedModel.id }}</p> <p class="badge bg-secondary text-light"> {{ getSelectedModel.engine }}</p>
                <p class="lead">{{ getSelectedModel.description }}</p>

                <p><span class="badge bg-info text-white"> Last Fine Tuned On: {{
                        formatDate(getSelectedModel.created)
                    }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import moment from "moment";

export default {
    name: 'ModelInfo',
    data() {
        return {};
    },
    computed: {
        ...mapGetters('model', ['getSelectedModel', 'getSelectedLoaded']),
    },
    created() {

    },
    methods: {
        formatDate(datetime) {
            return moment(datetime).format('DD MMMM YYYY HH:mm a');
        },
    },
    beforeUnmount() {

    },


}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.card-body{
    position: relative;
}
.lead-uuid {
    color: var(--bs-primary);
    padding: 10px;
    font-size: 12px;
    font-weight: bold;
    font-style: italic;
}
</style>
