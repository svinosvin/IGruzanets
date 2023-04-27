import './bootstrap';

import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js';
import components from './components/ui'
import store from "./store";
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/themes/lara-light-blue/theme.css';
import "@fortawesome/fontawesome-free/css/all.min.css";
const app = createApp(App)

app.use(PrimeVue);
app.use(ToastService);
app.use(ConfirmationService);

components.forEach(component =>{
    app.component(component.name, component)
})

app.use(router).use(store).mount('#app');
// app.config.globalProperties.axios = axios;

