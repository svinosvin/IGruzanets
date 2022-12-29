import axios from "axios";

const instance = axios.create({
    withCredentials: true,
    baseURL: import.meta.env.VUE_APP_URL_API,
    headers:{
        'Content-type': 'application/json',
        'X-Requested-With':'XMLHttpRequest'
    }

})
instance.interceptors.request.use(function (config){
    const token = localStorage.getItem('token');
    config.headers.Authorization =  token ? `Bearer ${token}` : '';
    return config;
})

export default instance
