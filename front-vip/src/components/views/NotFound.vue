<template>
  <div class="notFound">
    <h1 class="message">
      (404) Page NotFound
    </h1>

    <span class="routes">
      | <router-link to="/users/login">Login</router-link> |
      <router-link to="/users/register">Register</router-link> |
      <router-link to="/search/items">Search Items</router-link> |

    </span>
  </div>
</template>

<script>
export default {
  name: "NotFound"
}
</script>

<style scoped>

.notFound {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  grid-column: 2;
}

.message {
  line-height: 4em;
  color: #FFFFFF;
}

.routes * {
  color: #6246EA;
}

</style>