import { createRouter, createWebHistory } from 'vue-router';

import AppPage from './components/App.vue';

const routes = [
    { path: '/', redirect: '/app' },
    { path: "/app", component: AppPage, name: 'app', },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
})

export default router;