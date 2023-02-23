import axios from "axios";
import {ref} from "vue";
import {env} from "@/env";

const baseURL = env.API_URL_BASE
const favorites = ref(null)

const searchAPI = async (uri,favorites = []) => {

    const list = ref()
    const favoritesNew = ref()
    const error = ref()


    const token = JSON.parse(sessionStorage.getItem('user_token'))

    if (token) {
        await axios.post(baseURL + uri, {
            "favorites": favorites
        }, {
            headers: {'Authorization': `Bearer ${token['access_token']}`}
        }).then(response => {
            list.value = response.data.list ? response.data.list : null
            favoritesNew.value = response.data.favorites
        })
            .catch(err => error.value = err.response)
    } else {
        error.value = "user not logged in"
        this.$router.push("/users/login")
    }

    return {list, favoritesNew, error}

}
export default {
    async beforeMount() {
        const {list, favoritesNew, error} = await searchAPI('api/items/search')
        this.list = list;
        this.favorites = favoritesNew;
        this.error = error;

        if (this.error) {
            // this.$router.push("/users/login")
        }
    },
    data() {
        return {
            list: [],
            favorites:favorites,
            error: []
        }
    },
    methods: {
        favoritesAdd(id) {

            if (this.favorites.includes(id)) {
                this.favorites.splice(this.favorites.indexOf(id), 1);
            } else {
                this.favorites.push(id)
            }
        },
        async saveFavorites() {
            const {list, favoritesNew, error} = await searchAPI('api/items/insert',this.favorites)
            this.favorites = favoritesNew;
            this.error = error;
        }
    }
}

