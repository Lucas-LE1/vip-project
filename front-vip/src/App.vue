<template>

  <router-view class="router_view"></router-view>
  <div class="modal_div">
    <Modal :show="false"/>
  </div>

</template>
<script setup>
import Modal from "@/components/views/Modal.vue";
</script>