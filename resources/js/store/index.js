import {createStore} from 'vuex'
import authAdmin from "./modules/authAdmin";
import authUser from "./modules/authUser";
import driverModule from "./modules/driverModule";
import autoCategoryModule from "./modules/autoCategoryModule";
import serviceModule from "./modules/serviceModule";
import resourceModule from "./modules/resourceModule";
import subresourceModule from "./modules/subresourceModule";
import autoModule from './modules/autoModule';
import userModule from "./modules/userModule";
import employeeModule from "./modules/employeeModule";
import companyModule from "./modules/companyModule";

const store = createStore({
    modules:{
        autoModule,
        authAdmin,
        authUser,
        driverModule,
        autoCategoryModule,
        serviceModule,
        subresourceModule,
        resourceModule,
        userModule,
        employeeModule,
        companyModule,
    },

})
export default store;
