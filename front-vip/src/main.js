import {router} from "@/routes";
import {createApp} from 'vue'
import App from './App.vue'
import './assets/main.css'
import './env'


const app = createApp(App)
    .use(router)
    .mount('#app')