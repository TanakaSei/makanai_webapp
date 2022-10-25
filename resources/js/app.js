import './bootstrap'
import router from "./router";
import { createApp } from 'vue';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import app from './components/App.vue';
createApp(app).use(router).use(Antd).mount('#app');