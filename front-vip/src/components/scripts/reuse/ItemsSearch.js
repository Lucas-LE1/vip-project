import axios from "axios";
import {ref} from "vue";
import {env} from "@/env";

const baseURL = env.API_URL_BASE
const favorites = ref(null)

const searchAPI = async (uri, data) => {

    const list = ref()
    const favoritesNew = ref()
    const error = ref()


    const token = JSON.parse(sessionStorage.getItem('user_token'))

    if (token) {
        await axios.post(baseURL + uri, data, {
            headers: {'Authorization': `Bearer ${token['access_token']}`}
        }).then(response => {
            list.value = response.data.list ? response.data.list : null
            favoritesNew.value = response.data.favorites
        })
            .catch(err => error.value = err.response? err.response.data.error : err)

    } else {
        error.value = "user not logged in"
    }

    return {list, favoritesNew, error}

}
export default {
    async mounted() {
        await this.APISearch(this.$route.params.search);

    },
    data() {
        return {
            list: Array,
            favorites: favorites,
            error: [],
            search: ""
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
            const data = {
                "favorites": this.favorites ? this.favorites : []
            }

            const {favoritesNew, error} = await searchAPI('api/items/insert', data)
            this.favorites = favoritesNew;
            this.error = error;

            this.$emit('openModal', {
                message: this.favorites ? "favorites successfully saved" :
                    this.error
            })
        },
        async APISearch(searchList) {

            const data = {
                "search": searchList
            }

            const {list, favoritesNew, error} = await searchAPI(`api/items/search`, data)
            this.list = list;
            this.favorites = favoritesNew;
            this.error = error;

            if (this.error) {
                this.EmitEvent()
                this.$router.push("/users/login")
            }
        },
        async navigateList(searchList) {
            this.$router.push(`/search/items/return=${searchList}`)
            await this.APISearch(this.search);
        },
        logout() {
            this.$router.push("/users/login")
        },
        EmitEvent() {
            this.$emit("openModal", {message: this.error});
        }
    }
}

