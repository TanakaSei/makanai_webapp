import { createRouter, createWebHistory } from 'vue-router';

import HomePage from './components/App.vue';
import SettingPage from './components/SettingPage.vue';
import LotteryPage from './components/LotteryPage.vue';

const routes = [
    { path: '/', redirect: '/home' },
    { path: "/home", component: HomePage, name: 'home', },
    { path: "/setting", component: SettingPage, name: 'setting', },
    { path: "/lottery", component: LotteryPage, name: 'lottery', },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
})

export default router;