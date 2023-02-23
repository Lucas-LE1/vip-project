<template>
  <transition>
    <div :class="{ isActive: error }" class="error_div">
      <div class="message_div">
      <span class="message">
        Message de erro automaticaadasdasdsdMessage de erro automaticaadasdasdsd
      </span>
        <button class="error_button submit" @click="error = !error" >Understand</button>
      </div>
    </div>
  </transition>
</template>

<script setup>

const {error} = defineProps(['error'])
</script>

<style scoped>

.error_div {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  transition: opacity 0.3s ease;
}

.isActive {
  display: none;
}

.message_div {
  max-width: 250px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #181818;
  border-radius: 8px;
  padding: 25px 20px;
  gap: 10px;
}

.message_div * {
  color: #FFFFFF;
  font-size: .85em;
}

.error_button {
  width: min-content;
  line-height: 1em;
}

</style>