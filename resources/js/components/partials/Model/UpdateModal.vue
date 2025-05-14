<template>
    <div class="card-body text-start">
        <h4>Update Model Info</h4>
        <div class="alert p-2" v-if="message || error" :class="message?'alert-success':'alert-danger'">
            <i class="bi-check-circle"></i> {{ message || error }}
        </div>
        <form @submit.prevent="updateModal">
            <div class="mb-3">
                <label for="title" class="form-label">Name</label>
                <input type="text" id="modelName" class="form-control form-control-md" v-model="title" required
                       :disabled="!unlocked"/>
            </div>
            <div class="mb-3">
                <label for="type-select" class="form-label">Model Type</label>
                <select v-model="type" class="form-select form-select-md" aria-label="Select Model Type"
                        id="type-select" :disabled="!unlocked">
                    <option>Select Engine</option>
                    <option v-for="(key, value) in types" :key="key" :value="key">{{
                            value
                        }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="engine-select" class="form-label">Engine</label>
                <select v-model="engine" class="form-select form-select-md" aria-label="Select Engine"
                        id="engine-select" :disabled="!unlocked">
                    <option>Select Engine</option>
                    <option v-for="(key, value) in engines" :key="key" :value="key">{{
                            value
                        }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" class="form-control form-control-md" v-model="description"
                          required :disabled="!unlocked"></textarea>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" v-model="json_response" id="jsonResponseCheck" @change="checkJsonResponse($event)"  :disabled="!unlocked">
                <label class="form-check-label m-lg-1" for="jsonResponseCheck">
                    Enable Json Response only in Completion.
                </label>
            </div>

            <div class="btn-group">
                <button class="btn btn-lg btn-dark fw-bold border-white bg-secondary" type="submit" v-if="!unlocked"
                        @click="unlocked=true"> Unlock Update
                </button>
                <button class="btn btn-lg btn-dark fw-bold border-white bg-secondary" type="submit"
                        :disabled="updating" v-if="unlocked">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="updating"></span>
                    {{ updating ? 'Updating...' : 'Update' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
export default {
    name: 'ModelUpdate',
    data() {
        return {
            types: {
                'Completion': 'completion',
                'Fine Tune': 'fine-tune',
                'Application Specific': 'application-specific',
            },
            json_response: false,
            response_type: 'default',
            engines: {
                'Ada': 'ada',
                'Gpt 3.5 Turbo': 'gpt-3.5-turbo',
                'Gpt 3.5 Turbo Instruct': 'gpt-3.5-turbo-instruct',
                'Davinci 002': 'davinci-002',
                'Babbage 002': 'babbage-002',
            },
            unlocked: false,
            updating: false,
            title: "",
            description: "",
            engine: "",
            type: "",
            message: "",
            error: "",
        };
    },
    computed: {
        ...mapGetters('model', ['getSelectedModel', 'getUpdate']),
    },
    created() {
        this.type = this.getSelectedModel.model_type
        this.title = this.getSelectedModel.name
        this.description = this.getSelectedModel.description
        this.engine = this.getSelectedModel.engine
        this.json_response = this.getSelectedModel.response_type === 'json'
        if(this.json_response){
            this.response_type = 'json'
        }
    },
    methods: {
        ...mapActions('model', ['httpUpdateModel', 'httpGetModelDetail']),
        async updateModal() {
            this.updating = true;
            if (this.title.trim() === '' || this.description.trim() === '') {
                this.error = 'Please fill in both Prompt and Completion.'
                return;
            }
            const modelUpdateData = {
                name: this.title,
                engine: this.engine,
                model_type: this.type,
                response_type: this.json_response ? 'json' : 'default',
                description: this.description,
            };
            const model_id = this.getSelectedModel.id
            await this.httpUpdateModel({uuid: model_id, data: modelUpdateData})
            if (this.getUpdate) {
                this.message = this.getUpdate.message
                await this.httpGetModelDetail(model_id)
            } else {
                this.error = this.getUpdate
            }
            this.updating = false;
        },

        checkJsonResponse(){
            this.response_type = this.json_response ? 'json':'default'
        }
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
