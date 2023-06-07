import  './bootstrap'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index.js';
import components from './components/ui'
import store from "./store";
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import AdminPageWrapper from './components/base/AdminPageWrapper.vue'
import ValidationComponent from './components/base/ValidationComponent.vue'

import Upload from './components/ui/Upload.vue'

const app = createApp(App)


app.use(PrimeVue);
app.use(ToastService);
app.use(ConfirmationService);
app.component('AdminPageWrapper', AdminPageWrapper);
app.component('Upload', Upload);
app.component('ValidationComponent', ValidationComponent);

components.forEach(component =>{
    app.component(component.name, component)
})

app.use(router).use(store).mount('#app');
// app.config.globalProperties.axios = axios;

window.app = app;
export default app;
