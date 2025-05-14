import {createStore} from 'vuex';
import persistedState from '../plugins/persistedState';

import user from './modules/user';
import model from './modules/model';
import supportdata from './modules/supportdata';

const store = createStore({
    modules: {
        user: user,
        model: model,
        supportdata: supportdata
    },
    plugins: [persistedState({key: 'SystemPersistedState', modules: ['user', 'model', 'supportdata']})],
});

export default store;
