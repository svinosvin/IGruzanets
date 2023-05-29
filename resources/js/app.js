import  './bootstrap'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js';
import components from './components/ui'
import store from "./store";
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
const app = createApp(App)
import '@vuepic/vue-datepicker/dist/main.css'



app.use(PrimeVue);
app.use(ToastService);
app.use(ConfirmationService);

components.forEach(component =>{
    app.component(component.name, component)
})

app.use(router).use(store).mount('#app');
// app.config.globalProperties.axios = axios;

window.app = app;
export default app;
