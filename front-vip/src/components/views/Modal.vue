<script>
export default {
  props: {
    show: Boolean,
    message:String
  }
}
</script>

<template>
  <Transition name="modal" class="transition_modal" v-show="this.$props.show">
    <div class="modal-wrapper">
      <div class="modal-container">
        <div class="modal-header">
          <span class="message_error" >{{ this.$props.message }}</span>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style>


.modal-wrapper {
  display: flex;
  //position:fixed;
  z-index: 9998;
}

.modal-container {
  width: 300px;
  margin: 0 auto;
  padding: 20px 30px;
  background-color: rgba(32, 32, 36);
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 3s ease;

}

.message_error {
  color: #FFFFFF;
  text-transform: uppercase;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>