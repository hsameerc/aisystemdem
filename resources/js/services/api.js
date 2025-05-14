import axios from 'axios';
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let csrf_token = document.head.querySelector('meta[name="csrf-token"]');

if (csrf_token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf_token.content;
    axios.defaults.headers.common['Accept'] = 'application/json';
    axios.defaults.headers.common['Content-Type'] = 'application/json';
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
const BASE_URL = 'http://localhost:8080';

function setAuthToken(token) {
    if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
        delete axios.defaults.headers.common['Authorization'];
    }
}
function setContentFile() {
    axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
}

const ApiService = {
    init(token) {
        setAuthToken(token);
    },
    async me() {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/me/?web`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async meStatus() {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/user/status`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async getModels(params) {
        // eslint-disable-next-line no-useless-catch
        try {

            console.log(axios.defaults.headers.common)
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${params??''}`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async getModelDetail(uuid) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${uuid}/`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async validateModelData(uuid) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${uuid}/validate/`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async getSupportData(params) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${params.uuid}/supportdata/${params.params??''}`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async getSupportDataDetail(uuid) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${uuid}/supportdata/`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async createModelData(data) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.post(`${BASE_URL}/api/v1/support/model/`, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async updateModelData(uuid, data) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.put(`${BASE_URL}/api/v1/support/model/${uuid}/`, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async createSupportData(uuid, data) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.post(`${BASE_URL}/api/v1/support/model/${uuid}/supportdata/`, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async importSupportData(uuid, data) {
        setContentFile()
        // eslint-disable-next-line no-useless-catch
        try {

            const response = await axios.post(`${BASE_URL}/api/v1/support/model/${uuid}/supportdata/import/`, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async fineTuneModel(uuid) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/api/v1/support/model/${uuid}/finetune/`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async testModel(uuid, data) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.post(`${BASE_URL}/api/v1/support/model/${uuid}/test/`, data);
            return response.data;
        } catch (error) {
            throw error;
        }
    },
    async deleteSupportData(id) {
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.delete(`${BASE_URL}/api/v1/support/model/supportdata/${id}/`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },


    async fetchOauthToken(){
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.get(`${BASE_URL}/oauth/personal-access-tokens`);
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    async createToken(data){
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.post(`${BASE_URL}/oauth/personal-access-tokens`, data);
            return response.data;
        } catch (error) {
            throw error;
        }

    },

    async revokeToken(tokenId){
        // eslint-disable-next-line no-useless-catch
        try {
            const response = await axios.delete(`${BASE_URL}/oauth/personal-access-tokens/${tokenId}`);
            return response.data;
        } catch (error) {
            throw error;
        }
    }
};

export default ApiService;
