import {createRouter, createWebHistory} from "vue-router";
import Main from "../views/base/Main.vue";
import Home from '../views/base/Home.vue'
import AdminMain from '../views/base/Admin/AdminMain.vue'
import Register from "../views/base/Auth/Register.vue";


const routes = ([
    {

        path: '/',
        component: Main,

        children :[
            {
                path:'/',
                redirect: 'home'
            },
            {
                path:'home',
                component: Home,
                name: 'Home',

            },
            {
                path:'about',
                component:()=> import('../views/base/About.vue')
            },
            {
                path:'reviews',
                component:()=> import('../views/base/Reviews.vue')
            },
            {
                path:'services',
                component:()=> import('../views/base/Services.vue')
            },
            {
                path:'profile',
                component:()=> import('../views/base/Profile.vue')
            },
        ]
    },
    {
        path: '/register',
        component: ()=>import('../views/base/Auth/Register.vue'),
        name: 'Register'

    },
    {
        path: '/login',
        component:()=> import('../views/base/Auth/Login.vue'),
        name: 'Login'

    },

    {
    path: '/admin',
    component: AdminMain,
    children :[
        {
            path:'',
            component: ()=>import('../views/base/Admin/Pages/AdminHome.vue'),
            name: 'AdminHome',
        },
        {
            path:'services',
            component:()=> import('../views/base/Admin/Pages/AdminServices.vue')
        },
        {
            path:'drivers',
            component:()=> import('../views/base/Admin/Pages/AdminDrivers.vue')
        },

    ]},
    {
        path:'/admin/login',
        component: ()=> import('../views/base/Admin/AuthAdmin/Login.vue'),
        name: 'AdminLogin'

    },

])

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

router.beforeEach((to, from, next) =>{

    const user_token = localStorage.getItem('user-token');
    const admin_token = localStorage.getItem('admin-token');
    if(to.path.includes('admin')){
        if(!admin_token){
            if (to.name === 'AdminLogin'){
                return next();
            }
            else{
                return next({
                    name:'AdminLogin'
                });
            }
        }
        if(to.name === 'AdminLogin'){
            return next({
                name:'AdminHome'
            });
        }
        return next();

    }

    else {
        // if(!user_token){
        //     if (to.path === 'Login' || to.name === 'Register'){
        //         return next();
        //     }
        //     else {
        //         return next({
        //             name:'Login'
        //         });
        //     }
        // }
        // if(to.name === 'Login' || to.name === 'Register' && user_token){
        //     return next({
        //         name:'Home'
        //     });
        // }
        return next();
    }



});
export default router
