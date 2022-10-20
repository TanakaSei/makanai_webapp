import './bootstrap'
import router from "./router";
import { createApp } from 'vue';
import app from './components/App.vue'

createApp(app).use(router).mount('#app');