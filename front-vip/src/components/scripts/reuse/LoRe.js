import {env} from "@/env";
import axios from "axios";
import {ref} from "vue";

export const LoRe = async (checkForm, uri) => {

    const error = ref()

    let {errors, email, password, admin} = checkForm();

    function EmptyObject() {
        for (let prop in errors.value) {
            if (errors.value.hasOwnProperty(prop)) return false;
        }
        return true;
    }

    console.log(EmptyObject())

    const publicEnvVar = env.API_URL_BASE;

    if (EmptyObject()) {
        await axios.post(publicEnvVar + uri,
            {
                'email': email.value,
                'password': password.value,
                'admin': admin ? parseInt(admin.value) : null
            })
            .then((response) => {
                sessionStorage.setItem('user_token',
                    JSON.stringify(response.data))
            })
            .catch(async (err) => {
                error.value = await err
                // console.log(error.value)
            })
    }
    return {error};
eee
}
