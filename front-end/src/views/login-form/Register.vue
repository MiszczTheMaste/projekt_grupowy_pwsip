<template>

  <form id="login-form">

    <label>Login</label>
    <input type='text' v-model="login" required>

    <label>Hasło</label>
    <input type='password' v-model="password" required>

    <label>Powtórz Hasło</label >
    <input type='password' v-model="password2" required>

    <div id="rules" class="pretty p-default">
      <input type="checkbox" checked/>
      <div class="state">
        <label>Akceptuję regulamin</label>
      </div>
    </div>


    <button v-if="!loading" @click = 'register'>Zarejestuj</button>
    <button v-if="loading"><i class="fas fa-spinner"></i></button>

    <div class="footer">
      <label id="login-m" @click="changeForm('login')">Logowanie</label>
      <label id="lose-pass">Zapomniałem hasła</label>
    </div>
  </form>

</template>

<script>
const env = require('@/assets/env');

export default {
  name: "Register",
  data() {
    return {
      login : '',
      password : '',
      password2 : '',
      loading : false,
    }
  },
  methods: {
    changeForm(type) {
      this.$emit('changeForm',type);
    },
    async register () {
      if(this.password !== this.password2) return this.$alert('Hasła są różne!','error');
      if(!this.password || !this.login) return this.$alert('Uzupełnij wszystkie pola!','error')

      if(this.loading) return;
      this.loading = true;

      const response = await axios.post(env.register,{
        username : this.login,
        password: this.password,
      }).catch((error) =>{
        if (error.response) {
           return this.$alert(error.response.data.message || "Wystąpił błąd podczas połączenia!",'error')
        }
      });

      this.loading = false;

      if(!response) return; //Error

      if(response.status == 201) {
        this.$emit('changeForm','login');
        this.$alert('Rejestracja przebiegła pomyślnie, możesz się zalogować.','success',true,5000);
      }
    }

  },
}
</script>

<style>
.swal2-popup {
  font-size: 15px;
  font-family: Arial;
}
</style>