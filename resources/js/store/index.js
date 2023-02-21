import {createStore} from 'vuex'
import authAdmin from "./modules/authAdmin";
import authUser from "./modules/authUser";
import driverModule from "./modules/driverModule";
import autoCategoryModule from "./modules/autoCategoryModule";
const store = createStore({
    modules:{

        authAdmin,
        authUser,
        driverModule,
        autoCategoryModule

    },

})
export default store;
