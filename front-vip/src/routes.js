import {createRouter, createWebHashHistory} from 'vue-router'
import Login from "@/components/views/Login.vue";
import Register from "@/components/views/Register.vue";
import NotFound from "@/components/views/NotFound.vue";
import ItemsSearch from "@/components/views/ItemsSearch.vue";



const routes = [
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
    { path: '/users/login', name:'login', component: Login },
    { path: '/users/register', name:'register',component: Register },
    { path: '/search/items/return=:search?', name:'searchItems',component: ItemsSearch },
]

export const router = createRouter({
    history: createWebHashHistory(),
    routes,

})