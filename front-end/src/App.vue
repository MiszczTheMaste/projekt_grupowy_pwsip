<template>
  <div id="nav">
   <div class="search" v-if="currentRouteName === 'Home'">
    <span class="form-element">
      <span class="fa fa-search"></span>
      <input placeholder="Znajdz przedmiot" v-model="filters.findItemInput">
     </span>
    </div>

    <router-link :to="{name:'Home'}">
      <i class="fas fa-home"></i>
      <b>Strona Główna</b>
    </router-link>

    <router-link :to="{name:'Favorite'}">
      <i class="fas fa-heart"></i>
      <b>Ulubione</b>
    </router-link>

    <router-link :to="{name:'Basket'}">
      <div class="basket-items" v-show="basketItems !== 0">{{basketItems}}</div>
      <i class="fas fa-shopping-cart"></i>
      <b>Koszyk</b>
    </router-link>

    <router-link :to="{name:'Login'}" v-if="!username">
      <i class="fas fa-user-alt"></i>
      <b>Zaloguj</b>

    </router-link>

    <router-link :to="{name:'Account'}" v-if="username">
      <i class="fas fa-user-cog"></i>
      <b>{{username}}</b>
    </router-link>

    <a href="#" id="logout" v-if="username" @click="logout">
      <i class="fas fa-sign-out-alt"></i>
    </a>

  </div>

  <router-view
      :filters = 'filters'
      @changeBasketAmount = 'changeBasketAmount'
  />

  <transition name="fade">
    <div class="loader-main-page" v-if="!loadInits">
      <i class="fas fa-circle-notch"></i>
    </div>
  </transition>

</template>

<script>
const env = require('./assets/env');

export default {
  name: "App",
  data() {
    return {
     loadInits : false,
     session : localStorage.getItem('jwt'),
     username : null,
     basketItems : localStorage.getItem('basket-storage') ? JSON.parse(localStorage.getItem('basket-storage')).length : 0,
     filters: {
       findItemInput:'',
     }
    }
  },
  beforeMount() {
    if(this.session) {
      this.checkSession();
    }else{
      this.loadInits = true;
    }
  },
  computed: {
    currentRouteName() {
      return this.$route.name;
    }
  },
  methods: {
    changeBasketAmount(t) {
      this.basketItems+=t;
    },

    async checkSession() {
      const response = await axios(
          {
            url: env.session,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {
        if (error.response) {
          localStorage.removeItem('jwt');
          return this.$alert(error.response.data.message || "Wystąpił błąd podczas połączenia!", 'error')
        }
      });

      this.loadInits = true;
      if(!response) return;

      this.username = response.data.username;
    },

    logout() {
      localStorage.removeItem('jwt');
      location.reload();
    }
  },
}
</script>


<style>
html{
  font-family: Arial;
}
#logout i {
  font-size:15px !important;
  margin-left: -14px !important;
}

.loader-main-page {
  display:flex;
  position:absolute;
  background: #2b2b36;;
  width:100vw;
  height:100vh;
  justify-content: center;
  align-items: center;
  font-size:30px;
  z-index: 2;
  box-shadow:inset 0px 0px 50px 10px #313030;
  color: #a1a0a0;
  left:0px;
  top: 0px
}

.loader-main-page i {
  position: absolute;
  font-size: 80px;
  width: auto;
  height:auto;
  opacity:0.3;
  animation: loadingCircle 1s linear infinite;
}

@keyframes loadingCircle {
  0% {transform:rotate(360deg)}
}

.basket-items {
  display:flex;
  color:#cccccc !important;
  font-size:12px !important;
  position:absolute;
  right: 10px;
  top: 2px;
  background: #414152;
  width:12px;
  height:12px;
  padding:2px;
  font-family: Arial;
  border-radius:50%;
  align-items: center;
  justify-content: center;
}
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track{
  background: rgb(46 46 45);
  border-radius: 8px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #1e1d1d;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.btn-blue {
  background: rgb(58 130 239);
  border: 2px solid rgb(58 130 255);
  border-radius: 8px;
  padding: 8px;
  color: #23232d;
  font-weight: 600;
  text-transform: uppercase;
  cursor: pointer;
}

.btn-blue :hover{
  box-shadow: 0px .5px 5px #1145c7;
}

body {
  background-color: #2b2b36;
  color:#cccccc;
  width: 100%;
  height: 100%;
  margin:0;
}
#nav{
  background-color: #23232d;
  display: flex;
  text-decoration: none;
  color: #cccccc;
  flex-direction: row;
  justify-content: flex-end;
  height: 60px;
  box-shadow: 0px 1px 5px #2d4350;
}

#nav a {
  position: relative;
  display: flex;
  text-decoration: none;
  color: #cccccc;
  font-size: 25px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-right: 20px;
  padding: 10px;
}

.search {
  display: flex;
  color: #aaa;
  font-size: 16px;
  align-items: center;
  width: 70%;
  justify-content: center;
}

.form-element {
  position: relative;
  width: 30%;
}

.search input {
  background: transparent;
  border: 1px solid #7c7c7e;
  padding: 8px;
  color: #cccccc;
  font-weight: 600;
  border-radius: 20px;
}

.search input {
  text-indent: 1em;
  padding-right: 30px;
  width: 100%;
}

.search .fa-search {
  position: absolute;
  top: 8px;
  right: -25px;
  bottom: 0;
}
#nav i {
  font-size: 25px;
}

#nav b {
  font-size: 13px;
  margin-top: 5px;
}

#nav label {
  justify-content: flex-start !important;
}

#nav .router-link-active {
  color: rgb(58 130 239);
  box-shadow: 0 8px 6px -6px #1145c7;
}

input {
  outline-style: none;
}
</style>
