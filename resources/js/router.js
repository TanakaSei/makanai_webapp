import { createRouter, createWebHistory } from 'vue-router';

import App from './Pages/App.vue';
import HomePage from './Pages/HomePage.vue';
import SettingPage from './Pages/SettingPage.vue';
import LotteryPage from './Pages/LotteryPage.vue';

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