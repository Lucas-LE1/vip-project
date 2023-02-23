<template>
  <div class="one_div">
    <img src="../icons/developer.svg" alt="developer photo" class="developer">
    <span class="information_app">Developer by <a href="https://github.com/Lucas-LE1"
                                                  class="link">Lucas Eduardo</a></span>
    <span class="information_app">Access my instagram - <a href="#" class="link">@olucaseduardo0</a></span>
    <h1 class="title_page">{{ title }}</h1>
    <img src="../icons/companylog.svg" alt="company logo" class="company_logo">
  </div>
</template>

<script setup>

const {title} = defineProps(['title'])
</script>

<style scoped>

</style>