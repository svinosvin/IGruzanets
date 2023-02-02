import {createStore} from 'vuex'
import authAdmin from "./modules/authAdmin";
import authUser from "./modules/authUser";
import driverModule from "./modules/driverModule";
const store = createStore({
    modules:{

        authAdmin,
        authUser,
        driverModule
    },

})
export default store;
