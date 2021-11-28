<template>

  <form id="login-form">

    <label>Login</label>
    <input type='text'>

    <label>Hasło</label>
    <input type='password'>

    <button>Zaloguj</button>

    <div class="footer">
      <label id="register" @click="changeForm('register')">Rejestracja</label>
      <label id="lose-pass">Zapomniałem hasła</label>
    </div>
  </form>



</template>

<script>
import Register from "@/views/login-form/Register";

export default {
  name: "Login",
  components:{Register},
  methods: {
    changeForm(type) {
      this.$emit('changeForm',type);
    }
  },
}
</script>

<style>

</style>