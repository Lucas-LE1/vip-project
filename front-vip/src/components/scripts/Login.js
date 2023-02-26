import HeaderLoRe from "@/components/views/HeaderLoRe.vue";
import {ref} from "vue";
import {LoRe} from "@/components/scripts/reuse/LoRe";

const email = ref("")
const password = ref("")

const errors = ref({})
const checkForm = () => {
    if (email.value === "") {
        errors.value['email'] = email;
    } else {
        delete errors.value['email']
    }
    if (password.value === "") {
        errors.value['password'] = password;
    } else {
        delete errors.value['password']
    }

    return {
        errors,
        email,
        password
    };

}
export default {
    mounted() {
        sessionStorage.clear();
        email.value = "";
        password.value = "";
    },
    components: {HeaderLoRe},
    data() {
        return {
            errors,
            email,
            password,
            passwordVisible: true,
            errorRequest: {}
        }
    },
    methods: {
        async init() {
            const {error} = await LoRe(checkForm, 'api/users/login')
            if (error.value) {
                this.errorRequest['error'] = error.value
            } else {
                delete this.errorRequest['error']
                this.$router.push('/search/items/return=')
            }
        }
    }
}
