// router.js
import { createRouter, createWebHistory } from "vue-router";
import Basic from "./Pages/Basic.vue";
import App from "./Pages/App.vue";
import Address from "./Pages/Address.vue";
import Family from "./Pages/Family.vue";
import Education from "./Pages/Education.vue";
import Work from "./Pages/Work.vue";
import Achievement from "./Pages/Achievement.vue";
import Login from "./Pages/Login.vue";
import Print from "./Pages/Print.vue";

// Define your routes
export const routes = [
    { path: '/', component: App, name: 'Home', meta: { requiresAuth: true } },
    { path: '/basic', name: 'Basic', component: Basic, meta: { requiresAuth: true } },
    { path: '/address', component: Address, name: 'Address', meta: { requiresAuth: true } },
    { path: '/family', component: Family, name: 'Family', meta: { requiresAuth: true } },
    { path: '/education', component: Education, name: 'Education', meta: { requiresAuth: true } },
    { path: '/work', component: Work, name: 'Work', meta: { requiresAuth: true } },
    { path: '/achievement', component: Achievement, name: 'Achievement', meta: { requiresAuth: true } },
    { path: '/login', component: Login, name: 'Login', meta: { requiresAuth: false } },
    { path: '/print', component: Print, name: 'Print', meta: { requiresAuth: true } },
];

// Create router instance
const router = createRouter({
    history: createWebHistory(),
    routes
});

// Function to check authentication
router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const authenticated = window.authenticated;

    if (requiresAuth && !authenticated) {
        next('/login');
    } else if (authenticated && to.path === '/login') {
        next('/basic');
    } else {
        next();
    }
});

export default router;
