<template>
    <div class="text-start p-3">
        <div class="alert p-2" v-if="message || error" :class="message?'alert-success':'alert-danger'">
            <i class="bi-check-circle"></i> {{ message || error }}
        </div>
        <form @submit.prevent="saveModel">
            <div class="mb-3">
                <label for="prompt" class="form-label">{{ promptName }}</label>
                <textarea type="text" id="prompt" class="form-control" v-model="prompt" required  @input="tokenExceededCheck()"></textarea>
            </div>
            <div class="mb-3">
                <label for="completion" class="form-label">{{ completionName }}</label>
                <textarea id="completion" class="form-control" v-model="completion" required   @input="tokenExceededCheck()"></textarea>
            </div>
            <div class="btn-group">
                <button class="btn btn-lg btn-light fw-bold border-white bg-secondary text-white" type="submit"
                        :disabled="creating || hasErrors">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="creating"></span>
                    {{ creating ? 'Creating...' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'AddSupportData',
    data() {
        return {
            creating: false,
            prompt: '',
            completion: '',
            message: '',
            error: '',
            promptName: '',
            completionName: '',

        };
    },
    computed: {
        ...mapGetters('supportdata', ['getCreate']),
        ...mapGetters('model', ['getSelectedModel',]),
        hasErrors() {
            return this.prompt.length < 5 || this.prompt.length > 100 || this.completion.length < 10 || this.completion.length > 500;
        },

    },
    created() {
        this.promptName = this.getSelectedModel.model_type === "finetune" ? "Prompt": "Role"
        this.completionName = this.getSelectedModel.model_type === "finetune" ? "Completion": "Content"
    },
    methods: {
        tokenExceededCheck() {
            this.error = ""
            const tokens = this.completion.length + this.prompt.length
            if(tokens > 2048){
                this.error = "Prompt and Completion Length exceeds 2048 tokens."
                return true;
            }
            return false;
        },
        ...mapActions('supportdata', ['httpCreateSupportData',]),
        async saveModel() {
            this.creating = true
            if (this.prompt.trim() === '' || this.completion.trim() === '') {
                this.error = 'Please fill in both Prompt and Completion.';
                return;
            }

            const model_uuid = this.getSelectedModel.id
            const newSupportData = {
                support_model: model_uuid,
                prompt: this.prompt,
                completion: this.completion,
            };
            console.log('Saving SupportData:', newSupportData);
            await this.httpCreateSupportData(newSupportData)
            const createResponse = this.getCreate
            if (createResponse.status) {
                this.message = createResponse.message
            } else {
                this.error = createResponse.message
            }
            this.prompt = '';
            this.completion = '';
            this.creating = false
        },

    },
    watch:{

    }

}
</script>

<style scoped>
.fs12{
    font-size: 11px;
    color: gray;
}
</style>
