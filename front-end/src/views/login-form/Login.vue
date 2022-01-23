<template>

  <form id="login-form">

    <label>Login</label>
    <input type='text' v-model="login" required>

    <label>Hasło</label>
    <input type='password' v-model="password" required>

    <button v-if="!loading" @click='loginFunction'>Zaloguj</button>
    <button v-if="loading"><i class="fas fa-spinner"></i></button>

    <div class="footer">
      <label id="register" @click="changeForm('register')">Rejestracja</label>
      <label id="lose-pass">Zapomniałem hasła</label>
    </div>
  </form>
</template>

<script>
const env = require('@/assets/env');

import Register from "@/views/login-form/Register";
import Alerts from "@/components/Alerts";

export default {
  name: "Login",
  components:{Register,Alerts},
  data() {
    return {
      login : '',
      password : '',
      loading : false,
    }
  },
  methods: {
    changeForm(type) {
      this.$emit('changeForm',type);
    },
    async loginFunction() {
        if(!this.password || !this.login) return this.$alert('Uzupełnij wszystkie pola!','error')

        if(this.loading) return;
        this.loading = true;

        const response = await axios.post(env.login,{
          username : this.login,
          password: this.password,
        }).catch((error) =>{
          if (error.response) {
            return this.$alert(error.response.data.message || "Wystąpił błąd podczas połączenia!",'error')
          }
        });

      this.loading = false;
      if(!response) return;

      const jwt = response.data.token;

      localStorage.setItem('jwt',jwt);

      this.$alert('Zalogowano pomyślnie!','success',false,5000)
      this.$router.push({ name: 'Home'});

      setTimeout(()=>{
        location.reload();
      },200)
    }
  },
}
</script>

<style>
.fa-spinner {
  font-size: 20px;
  animation: spinAnimation 1s infinite ease-in-out;
}

@keyframes spinAnimation {
  0% {transform: rotate(360deg)}
}
</style>