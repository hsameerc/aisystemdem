<template>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between bg-white">
                        <div class="title card-title text-dark mb-0">
                            <span class="fs-5"> {{
                                    isFineTune ? "Fine Tune Data" : "Completion Messages (Role & Content)"
                                }}</span>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light fw-bold border-white bg-white"
                                    v-if="listSupportData || addSupportData"
                                    @click="toggleAddList('upload')"><i class="bi-upload"></i> Import {{ isFineTune ? "Fine Tune Data" : "Messages" }}
                            </button>
                            <button type="button" class="btn btn-sm btn-light fw-bold border-white bg-white"
                                    v-if="listSupportData || uploadSupportData"
                                    @click="toggleAddList('add')"><i class="bi-plus"></i>New
                                {{ isFineTune ? "Fine Tune Data" : "Message" }}
                            </button>
                            <button type="button" class="btn btn-sm btn-light border-white bg-white "
                                    v-if="addSupportData || uploadSupportData"
                                    @click="toggleAddList('list')"><i class="bi-list"></i> List
                                {{ isFineTune ? "Fine Tune Data" : "Messages" }}
                            </button>
                        </div>
                    </div>
                    <add-support-data v-if="addSupportData"></add-support-data>
                    <import-support-data v-if="uploadSupportData"></import-support-data>
                    <div class="card-body text-start" v-if="listSupportData">
                        <div class="spinner-border text-primary" role="status" v-if="loading">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <table class="table table-responsive table-striped-columns">
                            <thead>
                            <tr>
                                <th scope="col">{{ promptName }}</th>
                                <th scope="col">{{ completionName }}</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="supportData in getSupportData.results" :key="supportData.id">
                                <td>
                                    <span v-if="!showFullText[supportData.id]">{{
                                            truncatedSentence(supportData.prompt)
                                        }}</span>
                                    <span v-else>{{ supportData.prompt }}</span>
                                </td>
                                <td>
                                    <span v-if="!showFullText[supportData.id]">{{
                                            truncatedSentence(supportData.completion)
                                        }}</span>
                                    <span v-else>{{ supportData.completion }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn bg-secondary text-white" v-if="!showFullText[supportData.id]"
                                                @click="toggleFullText(supportData.id)"><i class="bi-chevron-down"></i>
                                        </button>
                                        <button class="btn btn-light" v-else @click="toggleFullText(supportData.id)"><i
                                            class="bi-chevron-up"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                @click="deleteSupportData(supportData.id)"><i
                                            class="bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <default-pagination :next="getSupportData.next" :previous="getSupportData.previous"
                                            :count="getSupportData.count"
                                            @page-changed="fetchSupportData"></default-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import DefaultPagination from "@/components/partials/Pagination.vue";
import AddSupportData from "@/components/partials/AddSupportData.vue";
import ImportSupportData from "@/components/partials/ImportSupportData.vue";

export default {
    name: 'SupportDataList',
    components: {ImportSupportData, AddSupportData, DefaultPagination},
    data() {
        return {
            loading: false,
            listSupportData: true,
            addSupportData: false,
            uploadSupportData: false,
            showFullText: [],
            isFineTune: false,
            promptName: '',
            completionName: ''
        }
    },
    created() {
        this.isFineTune = this.getSelectedModel.model_type === "fine-tune"
        this.promptName = this.getSelectedModel.model_type === "fine-tune" ? "Prompt" : "Role"
        this.completionName = this.getSelectedModel.model_type === "fine-tune" ? "Completion" : "Content"
    },
    props: {
        model_uuid: String
    },
    computed: {
        ...mapGetters('supportdata', ['getSupportData', 'getLoaded']),
        ...mapGetters('model', ['getSelectedModel']),
    },
    methods: {
        ...mapActions('supportdata', ['httpGetSupportData', 'httpDeleteSupportData', 'unsetSupportData']),

        async fetchSupportData(page) {
            this.loading = true
            let urlParams = ''
            if (page) {
                urlParams = this.extractQueryParams(page)
            }
            await this.httpGetSupportData({uuid: this.model_uuid, params: urlParams})
            this.loading = false
        },

        async deleteSupportData(id) {
            this.loading = true
            await this.httpDeleteSupportData(id)
            this.loading = false
            await this.fetchSupportData()
        },

        extractQueryParams(page) {
            const queryString = page;
            const queryParams = queryString.split('?');
            return '?' + queryParams[1] ?? '';
        },

        toggleAddList(label) {
            this.addSupportData = false;
            this.listSupportData = false;
            this.uploadSupportData = false;

            switch (label) {
                case 'add':
                    this.addSupportData = true;
                    break;
                case 'list':
                    this.fetchSupportData()
                    this.listSupportData = true;
                    break;
                case 'upload':
                    this.uploadSupportData = true;
                    break;
            }
        },
        truncatedSentence(item) {
            const wordsToShow = 10;
            const wordsArray = item.split(" ");
            const truncatedArray = wordsArray.slice(0, wordsToShow);
            return truncatedArray.join(" ") + '...';
        },
        toggleFullText(index) {
            this.showFullText[index] = !this.showFullText[index];
        },
    },
    beforeUnmount() {
        this.unsetSupportData()
    }
}
</script>

<style>
.spinner-border {
    z-index: 999;
    position: absolute;
    top: 50%;
    left: 50%;
}
</style>
