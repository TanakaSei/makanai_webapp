import { createRouter, createWebHistory } from 'vue-router';

import App from './components/App.vue';
import HomePage from './components/HomePage.vue';
import SettingPage from './components/SettingPage.vue';
import LotteryPage from './components/LotteryPage.vue';

const routes = [
    { path: '/h', redirect: '/home' },
    { path: "/home", component: HomePage, name: 'home', },
    { path: "/setting", component: SettingPage, name: 'setting', },
    { path: "/lottery", component: LotteryPage, name: 'lottery', },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
})

export default router;