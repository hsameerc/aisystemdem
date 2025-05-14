import ApiService from "@/services/api";

const model = {
    namespaced: true,
    state: {
        loaded: false,
        selectedLoaded: false,
        models: {},
        selectedModal: {},
        detailPage: 'info',
        create: {},
        update: {},
        validation: {},
        fineTune: {},
        testModel: {},
    },
    mutations: {
        SET_SELECTED_MODAL_STATUS(state, status) {
            state.selectedLoaded = status;
        },
        SET_MODEL_LOADED(state, status) {
            state.loaded = status;
        },
        SET_MODELS(state, models) {
            state.models = models;
        },
        SET_SELECTED_MODAL(state, model) {
            state.selectedModal = model;
        },
        SET_DETAIL_PAGE(state, pageName) {
            state.detailPage = pageName;
        },
        SET_CREATE(state, data) {
            state.create = data;
        },
        SET_UPDATE(state, data) {
            state.update = data;
        },
        SET_VALIDATION(state, data) {
            state.validation = data;
        },
        SET_FINE_TUNE(state, data) {
            state.fineTune = data;
        },
        SET_TEST_MODEL(state, data) {
            state.testModel = data;
        },
    },
    actions: {
        async httpCreateModel({commit}, data) {
            try {
                await ApiService.createModelData(data);
                commit('SET_CREATE', {status: true, message: 'Modal Created Successfully. '})
            } catch (error) {
                commit('SET_CREATE', {status: false, message: error.message})
                throw error;
            }
        },
        async httpUpdateModel({commit}, params) {
            try {
                await ApiService.updateModelData(params.uuid, params.data);
                commit('SET_UPDATE', {status: true, message: 'Modal Updated Successfully. '})
            } catch (error) {
                commit('SET_UPDATE', {status: false, message: error.message})
                throw error;
            }
        },
        async httpGetModels({commit}, params) {
            try {
                const models = await ApiService.getModels(params);
                commit('SET_MODELS', models.data)
                commit('SET_MODEL_LOADED', true)
            } catch (error) {
                commit('SET_MODEL_LOADED', false)
                throw error;
            }
        },
        async httpGetModelDetail({commit}, uuid) {
            // eslint-disable-next-line no-useless-catch
            try {
                const model = await ApiService.getModelDetail(uuid);
                commit('SET_SELECTED_MODAL', model.data)
                commit('SET_SELECTED_MODAL_STATUS', true)
            } catch (error) {
                throw error;
            }
        },
        async httpValidateModel({commit}, uuid) {
            // eslint-disable-next-line no-useless-catch
            try {
                const validation = await ApiService.validateModelData(uuid);
                commit('SET_VALIDATION', validation.data)
                return validation.data
            } catch (error) {
                throw error;
            }
        },
        async httpFineTuneModel({commit}, uuid) {
            // eslint-disable-next-line no-useless-catch
            try {
                const fineTune = await ApiService.fineTuneModel(uuid);
                commit('SET_FINE_TUNE', fineTune.data)
                return fineTune.data
            } catch (error) {
                throw error;
            }
        },
        async httpTestModel({commit}, params) {
            // eslint-disable-next-line no-useless-catch
            try {
                const testModel = await ApiService.testModel(params.uuid, params.data);
                commit('SET_TEST_MODEL', testModel.data)
                return testModel.data
            } catch (error) {
                throw error;
            }
        },

        unsetSelectedModel({commit}) {
            commit('SET_SELECTED_MODAL', {})
            commit('SET_SELECTED_MODAL_STATUS', false)
        },

        setDetailPageName({commit}, pageName) {
            commit('SET_DETAIL_PAGE', pageName)
        }
    },
    getters: {
        getLoaded(state) {
            return state.loaded
        },
        getSelectedLoaded(state) {
            return state.selectedLoaded
        },
        getModels(state) {
            return state.models
        },
        getSelectedModel(state) {
            return state.selectedModal
        },
        getDetailPageName(state) {
            return state.detailPage
        },
        getCreate(state) {
            return state.create
        },
        getUpdate(state) {
            return state.update
        },
        getTestModel(state) {
            return state.testModel
        }
    },
}
export default model
