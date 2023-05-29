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
import orderModule from "./modules/orderModule";
import reviewModule from "./modules/reviewModule";
const store = createStore({
    modules:{
        reviewModule,
        orderModule,
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
