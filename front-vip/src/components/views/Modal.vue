<script>
export default {
  props: {
    show: Boolean
  }
}
</script>

<template>
  <Transition name="modal" class="transition_modal">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">default header</slot>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style>
.modal_div {
  position: absolute;
  display: flex;
  z-index: 9998;
  justify-self: flex-end;
  margin-top: 20px;
}

.modal-wrapper {
  display: flex;
  //position:fixed;
  z-index: 9998;
}

.modal-container {
  width: 300px;
  margin: 0 auto;
  padding: 20px 30px;
  background-color: #202024;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s revert;
}

.modal-container {

}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.modal-mask {
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  padding: 20px 20px;
}
</style>