import {ref} from 'vue'
import HeaderLoRe from "@/components/views/HeaderLoRe.vue";
import {LoRe} from "@/components/scripts/reuse/LoRe";


const email = ref('')
const password = ref('')
const admin = ref()

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
    if (typeof (admin.value) != "string") {
        errors.value['admin'] = admin;
    } else {
        delete errors.value['admin']
    }

    return {
        errors,
        email,
        password,
        admin
    };
}


export default {
    mounted() {
        sessionStorage.clear();
    },
    components: {HeaderLoRe},
    data() {
        return {
            errors,
            email,
            password,
            passwordVisible: true,
            admin,
            errorRequest: {}
        }
    },

    methods: {
        async init() {
            const {error} = await LoRe(checkForm, 'api/users/insert')

            if (error.value) {
                this.errorRequest['error'] = error.value
            } else {
                delete this.errorRequest['error']
                this.$router.push('/search/items/return=')

            }
        }
    }
}
