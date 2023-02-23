import {computed, ref} from 'vue'

import Login from "@/components/views/Login.vue";
import NotFound from "@/components/views/NotFound.vue";
import Register from "@/components/views/Register.vue";
import ErrorMessage from "@/components/views/ErrorMessage.vue";
import ItemsSearch from "@/components/views/ItemsSearch.vue";

export let errorStatus = ref(true)


const routes = {
    '/': null,
    '/login': Login,
    '/register': Register,
    '/search/items':ItemsSearch
}

const currentPath = ref(window.location.hash)

window.addEventListener('hashchange', () => {
    currentPath.value = window.location.hash
})

const currentView = computed(() => {
    let route = routes[currentPath.value.slice(1)]
    return route ? route : NotFound;
})


export default {
    components: {ErrorMessage},
    data() {
        return {
            currentView,
            errorStatus
        }
    }
}