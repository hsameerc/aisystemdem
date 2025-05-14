<template>
    <div class="card-body">
        <p>
            Open AI has developed a tool which fine tunes, gives model and chat data.
        </p>
        <div class="alert alert-info" v-if="disabledButton">{{message}}</div>
        <button class="btn btn-lg btn-dark fw-bold border-white bg-secondary" type="submit" :disabled="funeTuning || disabledButton"
                v-if="!response" @click="validateModel">
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="funeTuning"></span>
            {{ funeTuning ? 'Fine Tuning...' : 'Fine Tune' }}
        </button>
        <div class="alert alert-info" v-if="response">
            <p v-html="formattedResponse()"></p>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'FineTuneModal',
    data() {
        return {
            message: '',
            disabledButton: true,
            response: '',
            funeTuning: false,
        };
    },
    computed: {
        ...mapGetters('model', ['getSelectedModel']),
        ...mapGetters('supportdata', ['getSupportData']),
    },
    created() {
        if (this.getSupportData.count < 50) {
            this.message = "Insufficient Fine Tune Data for Validation. Please add at least 100 fine tune data."
        }else{
            this.disabledButton = false;
        }
    },
    methods: {
        ...mapActions('model', ['httpValidateModel', 'httpFineTuneModel']),
        async validateModel() {
            this.funeTuning = true;
            const uuid = this.getSelectedModel.id
            try {
                const data = await this.httpFineTuneModel(uuid)
                this.response = data.output.output
            } catch (e) {
                console.log(e)
            }
            this.funeTuning = false;
        },
        formattedResponse() {
            return this.response.replace(/\n/g, "<br>");
        },
    },
    beforeUnmount() {

    },


}
</script>

<style scoped>
.lead-uuid {
    color: var(--bs-primary);
    padding: 10px;
    font-size: 12px;
    font-weight: bold;
    font-style: italic;
}
</style>
