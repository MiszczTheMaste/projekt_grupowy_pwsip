<template>

  <form id="login-form">

    <label>Login</label>
    <input type='text' required>

    <label>Hasło</label>
    <input type='password' required>

    <label>Powtórz Hasło</label >
    <input type='password' required>

    <label>E-mail</label>
    <input type='email' required>

    <div id="rules" class="pretty p-default">
      <input type="checkbox" checked/>
      <div class="state">
        <label>Akceptuję regulamin</label>
      </div>
    </div>


    <button>Zarejestuj</button>

    <div class="footer">
      <label id="login-m" @click="changeForm('login')">Logowanie</label>
      <label id="lose-pass">Zapomniałem hasła</label>
    </div>
  </form>



</template>

<script>

export default {
  name: "Register",
  methods: {
    changeForm(type) {
      this.$emit('changeForm',type);
    }
  },
}
</script>

<style>
</style>