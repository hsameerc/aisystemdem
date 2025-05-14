<template>
    <div class="text-start p-3 text-center">
        <div class="form-group">
            <label class="btn btn-primary btn-file">
              <span class="spinner-grow text-light" role="status" v-if="loading">
                  <span class="visually-hidden">Importing...</span>
              </span>
                <span v-else>
                  Import JSON Fine Tune Data
              <input type="file" style="display: none" @change="handleFileChange">
              </span>
            </label>
            <div class="info mt-2 p-2 bg-light text-dark" v-if="isFineTune">
                <p class="info">Import fine tune data pattern message.</p>
                <p>
                    <code>
                        [{
                        "prompt": "Prompt",
                        "completion": "Completion"
                        },...]
                    </code>
                </p>
            </div>
            <div class="info mt-2 p-2 bg-light text-dark" v-if="!isFineTune">
                <p class="info">Import Chat Completion default message.</p>
                <p>
                    <code>
                        [{
                        "role": "system",
                        "completion": "You are a helpful assistant."
                        },
                        {
                        "role": "user",
                        "completion": "Who won the world series in 2020?"
                        },
                        {
                        "role": "assistant",
                        "completion": "The Los Angeles Dodgers won the World Series in 2020."
                        },...]
                    </code>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'ImportSupportData',
    data() {
        return {
            loading: false,
            isFineTune: false,
            promptName: false,
            completionName: false,
        };
    },
    created() {
        this.isFineTune = this.getSelectedModel.model_type === "fine-tune"
        this.promptName = this.getSelectedModel.model_type === "fine-tune" ? "Prompt" : "Role"
        this.completionName = this.getSelectedModel.model_type === "fine-tune" ? "Completion" : "Content"
    },
    computed: {
        ...mapGetters('supportdata', ['getCreate']),
        ...mapGetters('model', ['getSelectedModel',]),
    },
    methods: {
        ...mapActions('supportdata', ['httpCreateSupportData', 'httpImportSupportData']),
        handleFileChange(event) {
            this.loading = true
            const file = event.target.files[0];
            if (file.length <= 0) {
                return false;
            }
            this.httpImportSupportData({
                support_model: this.getSelectedModel.id,
                file: file
            }).then((res) => {
                this.loading = false
            })
        },
    },

}
</script>

<style scoped>

</style>
