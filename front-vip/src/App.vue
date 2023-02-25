<template>

  <router-view @openModal="errorChange" class="router_view"></router-view>
  <div class="modal_div">
    <Modal :show="state" :message="message"/>
  </div>

</template>
<script setup>
import Modal from "@/components/views/Modal.vue";
import {ref} from "vue";

let state = ref(false)
let message = ref("Error Message")
const errorChange = (props) => {

  message.value = props.message

  state.value = !state.value
    setTimeout(()=> {
    state.value = !state.value
  },3000)
}
</script>