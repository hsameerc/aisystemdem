import NotFound from "@/components/main/NotFound.vue";
import MyDashboard from "@/components/main/Dashboard.vue";
import MyModels from "@/components/main/Models.vue";
import ModelDetail from "@/components/main/ModelDetail.vue";
import ManageToken from "@/components/main/ManageToken.vue";
import {createRouter, createWebHistory} from "vue-router";
import store from "@/services";
import MyAccount from "@/components/main/MyAccount.vue";
import TestModel from "@/components/main/TestModel.vue";
import Passport from "./components/passport/passport.vue";

const routes = [
    {
        name: 'home',
        path: '/app',
        meta: {layout: "user-layout", auth: true},
        component: MyDashboard
    },
    {
        name: 'my-profile',
        path: '/app/my-profile',
        meta: {layout: "user-layout", auth: true},
        component: MyAccount
    },
    {
        name: 'models',
        path: '/app/models',
        meta: {layout: "user-layout", auth: true},
        component: MyModels
    },
    {
        name: 'view-models',
        path: '/app/models/:uuid',
        meta: {layout: "user-layout", auth: true},
        component: ModelDetail
    },
    {
        name: 'test-model',
        path: '/app/models/:uuid/test',
        meta: {layout: "user-layout", auth: true},
        component: TestModel
    },
    {
        name: 'manage-token',
        path: '/app/token/manage',
        meta: {layout: "user-layout", auth: true},
        component: ManageToken
    },
    {
        name: 'my-passport',
        path: '/app/my-passport',
        meta: {layout: "user-layout", auth: true},
        component: Passport
    },
    {
        name: 'not-found',
        path: '/app/404',
        meta: {layout: "user-layout"},
        component: NotFound
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.fullPath.includes('/access')) {

    } else if (!to.matched.length) {
        next('/app/404');
    } else {
        const isLoggedIn = store.getters['user/isLoggedIn'];
        const requiresAuth = to.matched.some(record => record.meta.auth);
        const isGuestAllowed = to.matched.some(record => record.meta.guest);
        if (requiresAuth && !isLoggedIn) {
        } else if (isLoggedIn && isGuestAllowed) {
            next('/app');
        } else {
            next()
            console.log(isLoggedIn, 'Login/Register')
        }
    }
});

export default router;
