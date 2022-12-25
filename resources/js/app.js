import './bootstrap';


import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js';
import store from "./store";
import components from './components/ui'

// import router from './router'
// import axios from "axios";

const app = createApp(App)

components.forEach(component =>{
    app.component(component.name, component)
})

app.use(router)
// app.config.globalProperties.axios = axios;

app.mount('#app')
