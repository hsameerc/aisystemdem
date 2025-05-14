import moment from "moment";
import ApiService from '@/services/api';

const user = {
    namespaced: true,
    state: () => ({
        loggedIn: false,
        user: {},
        token: '',
        tokenExpiry: '',
    }),
    mutations: {
        SET_LOGGED_IN_STATUS(state, status) {
            state.loggedIn = status;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_TOKEN_EXPIRY(state, expiry) {
            state.tokenExpiry = expiry;
        },
        SET_LOG_IN_ERRORS(state, errors) {
            state.loginErrors = errors;
        },
    },
    actions: {
        async setMeDefaults({getters}) {
            ApiService.init(getters.getToken);
        },
        async httpMeStatus({commit}) {
            try {
                return await ApiService.meStatus();
            } catch (error) {
                throw error;
            }
        },
        async httpMe({commit}) {
            try {
                const user = await ApiService.me();
                commit('SET_LOGGED_IN_STATUS', true)
                commit('SET_USER', user.user)
                commit('SET_TOKEN', user.token)
                commit('SET_TOKEN_EXPIRY', user.token_expiration)
                commit('SET_LOG_IN_ERRORS', false)
                ApiService.init(user.token);
            } catch (error) {
                commit('SET_LOG_IN_ERRORS', error.message)
                throw error;
            }
        },
    },
    getters: {
        isLoggedIn: (state) => {
            return state.loggedIn;
        },
        getUser: (state) => {
            return state.user;
        },
        getToken: (state) => {
            return state.token;
        },
        getLoginErrors: (state) => {
            return state.loginErrors;
        },
        getTokenExpiry: (state) => {
            return state.tokenExpiry;
        },
        getTokenExpiredStatus: (state) => {
            if (state.tokenExpiry) {
                return moment(state.tokenExpiry) > moment.now();
            }
            return false;
        }
    }
}

export default user
