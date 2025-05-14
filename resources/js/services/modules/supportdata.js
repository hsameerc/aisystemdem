import ApiService from "@/services/api";

const supportdata = {
    namespaced: true,
    state: {
        loaded: false,
        supportData: {},
        selectedSupportData: {},
        create: {},
    },
    mutations: {
        SET_SUPPORT_DATA_LOADED(state, status) {
            state.loaded = status;
        },
        SET_SUPPORT_DATA(state, supportData) {
            state.supportData = supportData;
        },
        SET_SELECTED_SUPPORT_DATA(state, supportData) {
            state.selectedSupportData = supportData;
        },
        SET_CREATE(state, data) {
            state.create = data;
        },
    },
    actions: {
        async httpImportSupportData({commit}, data) {
            // eslint-disable-next-line no-useless-catch
            try {
                await ApiService.importSupportData(data.support_model, {import_data: data.file});
                commit('SET_CREATE', {status: true, message: 'Fine Tune Data Imported Started Successfully.'})
            } catch (error) {
                commit('SET_CREATE', {status: false, message: error.message})
                throw error;
            }
        },
        async httpCreateSupportData({commit}, data) {
            // eslint-disable-next-line no-useless-catch
            try {
                await ApiService.createSupportData(data.support_model, data);
                commit('SET_CREATE', {status: true, message: 'Fine Tune Data Created Successfully. '})
            } catch (error) {
                commit('SET_CREATE', {status: false, message: error.message})
                throw error;
            }
        },
        async httpGetSupportData({commit}, params) {
            // eslint-disable-next-line no-useless-catch
            try {
                const supportData = await ApiService.getSupportData(params);
                commit('SET_SUPPORT_DATA_LOADED', true)
                commit('SET_SUPPORT_DATA', supportData.data)
            } catch (error) {
                commit('SET_SUPPORT_DATA_LOADED', false)
                throw error;
            }
        },
        async httpGetSupportDataDetail({commit}, uuid) {
            // eslint-disable-next-line no-useless-catch
            try {
                const model = await ApiService.getSupportDataDetail(uuid);
                commit('SET_SELECTED_SUPPORT_DATA', model.data)
            } catch (error) {
                throw error;
            }
        },
        async httpDeleteSupportData({commit}, id) {
            // eslint-disable-next-line no-useless-catch
            try {
                const model = await ApiService.deleteSupportData(id);
                commit('SET_SELECTED_SUPPORT_DATA', model)
            } catch (error) {
                throw error;
            }
        },

        unsetSupportData({commit}) {
            commit('SET_SELECTED_SUPPORT_DATA', {})
            commit('SET_SUPPORT_DATA_LOADED', false)
            commit('SET_SUPPORT_DATA', {})
        }
    },
    getters: {
        getLoaded(state) {
            return state.loaded
        },
        getSupportData(state) {
            return state.supportData
        },
        getSelectedSupportData(state) {
            return state.selectedSupportData
        },
        getCreate(state) {
            return state.create
        }
    },
}
export default supportdata
