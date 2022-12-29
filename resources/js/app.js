import './bootstrap';


import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js';
import components from './components/ui'
import store from "./store";

// import router from './router'
// import axios from "axios";

const app = createApp(App)

components.forEach(component =>{
    app.component(component.name, component)
})


app.use(router).use(store).mount('#app');
// app.config.globalProperties.axios = axios;

