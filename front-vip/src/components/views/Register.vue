<template>

  <div id="login">
    <HeaderLoRe title="Register Screen"/>

    <div class="two_div">
      <div v-if="'error' in this.errorRequest" class="error_div_in">
        <span class="error">{{ errorRequest.error }}</span>
      </div>
      <form method="post">
        <label class="label_inputs" for="email">Email address</label>
        <span class="error" v-if="('email' in errors)">fill in this field correctly</span>
        <input v-model="email" type="text" name="email" class="input" placeholder="Email address">

        <label class="label_inputs" for="password">Your password</label>
        <span class="error" v-if="('password' in errors)">fill in this field correctly</span>
        <div class="input_div_password">
          <input v-model="password" alt="password" :type="this.passwordVisible ? 'password' : 'text' " name="password" class="input"
                 placeholder="Your password" >
        <img v-if="this.passwordVisible" @click="this.passwordVisible = !this.passwordVisible" src="../icons/eyeTrue.svg" alt=""/>
        <img v-else @click="this.passwordVisible = !this.passwordVisible" src="../icons/eyeFalse.svg" alt=""/>
        </div>
        <label class="label_inputs" for="admin">Is admin?</label>
        <span class="error" v-if="('admin' in errors)">fill in this field correctly</span>
        <div class="radios">
          <input v-model="admin" type="radio" name="admin" class="radio" value=1> True
          <input v-model="admin" type="radio" name="admin" class="radio" value=0> False
        </div>
        <input class="submit" type="button" value="Register" @click="init">
      </form>

      <div class="instruction">
        <span>Do have an account?
          <router-link class="link" to="/users/login">Sing In</router-link></span>
      </div>

    </div>
  </div>
</template>

<script src="../scripts/Register.js"/>
<style src="../styles/Login.css"/>