import {createRouter, createWebHistory} from "vue-router";
import Main from "../components/Main.vue";
import Home from '../components/Home.vue'
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
    }
    // {
    // path: '/admin',
    // component: Main,
    // children :[
    //     {
    //
    //     }
    // ]},
])

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})
export default router
