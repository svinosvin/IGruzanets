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
    let token = localStorage.getItem('user-token');
    if(location.href.includes('admin'))
    {
        token = localStorage.getItem('admin-token');
    }

    config.headers.Authorization =  token ? `Bearer ${token}` : '';
    return config;
})
instance.interceptors.response.use({}, error => {
    console.log(error.response);
    if(error.response.status == 401 || error.response.status == 419){
        const token = localStorage.getItem('token');
        if(token){
            localStorage.removeItem('token');
        }

    }
})


export default instance
