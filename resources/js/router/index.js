import {createRouter, createWebHistory} from "vue-router";
import Main from "../components/Main.vue";
import Home from '../components/Home.vue'
import AdminMain from '../components/Admin/AdminMain.vue'


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
                component: Home
            },
            {
                path:'about',
                component: import('../components/About.vue')
            },
            {
                path:'reviews',
                component: import('../components/Reviews.vue')
            },
            {
                path:'services',
                component: import('../components/Services.vue')
            },
        ]
    },
    {
        path: '/register',
        component: import('../components/Auth/Register.vue')
    },
    {
        path: '/login',
        component: import('../components/Auth/Login.vue')
    },

    {
    path: '/admin',
    component: AdminMain,
    children :[
        {
            path:'',
            component: import('../components/Admin/Pages/AdminHome.vue')
        },
        {
            path:'services',
            component: import('../components/Admin/Pages/AdminServices.vue')
        },

    ]},
    {
        path:'/admin/login',
        component: import('../components/Admin/AuthAdmin/Login.vue')
    },

])

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})
export default router
