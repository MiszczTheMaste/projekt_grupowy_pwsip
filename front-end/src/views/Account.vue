<template>

  <div class="content-box-account" v-if="sessionStatus">

    <div class="cfg-box">
      <div class="cfg-space">
        <div class="cfg-title">Zmiana Hasła</div>
        <hr class="title-re">
        <div class="cfg-value">
          <span class="">Stare hasło</span>
          <input type="password" class="cfg-pass" v-model="oldPassword">
          <span class="">Nowe hasło</span>
          <input type="password" class="cfg-pass" v-model="newPassword">
          <span class="">Powtórz nowe hasło</span>
          <input type="password" class="cfg-pass" v-model="newPassword2">
          <button class="btn-cfg" @click="changePassword">Zmień</button>
        </div>
      </div>
    </div>


    <div class="cfg-box">
      <div class="cfg-title">Ocena zakupionych produktów</div>
      <hr class="title-re">
      <RateItem :products="itemsToRate" v-if="itemsToRate.length > 0" @removeItem="removeItemToRate"></RateItem>
      <div class='noneRate' v-if="itemsToRate.length === 0">Brak produktów do oceny.</div>
    </div>

    <AdminMenu v-if="userRoles !== 'ROLE_USER'" />
  </div>


  <transition name="fade">
    <Loader v-if="!sessionStatus" key="homeLoader"></Loader>
  </transition>


</template>

<script>
import Loader from "..//components/Loader";
import RateItem from "../components/RateItem";
import AdminMenu from "../components/AdminMenu";

import env from "../assets/env";

export default {
  name: "Account",
  components : {Loader,RateItem,AdminMenu},
  data() {
    return {
      sessionStatus: false,
      session : localStorage.getItem('jwt'),
      itemsToRate : [],
      userRoles : `ROLE_USER`,
      newPassword : '',
      newPassword1 : '',
      oldPassword : '',
    }
  },
  beforeMount() {
    this.checkSession();
  },

  methods: {

    setStorage(key,value) {
      localStorage.setItem(key,JSON.stringify(value))
    },

    getStorage(key) {
      if(!localStorage.getItem(key)) this.setStorage(key,[])
      return JSON.parse(localStorage.getItem(key));
    },

    async checkSession() {
      if(this.sessionStatus) return;

      const response = await axios(
          {
            url: env.session,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {
        if (error.response) {
          localStorage.removeItem('jwt');
          return this.$alert("Nie jesteś zalogowany, zaloguj się aby zmienić ustawienia konta!", 'error',true,5000)
        }
      });

      this.sessionStatus = true;
      if(!response) return;

      this.userRoles = response.data.roles[0];
      this.getRateItems();
    },

    async getRateItems() {
      const rated = await axios(
          {
            url: env.rated_items,
            method: "get",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {
        if (error.response) {
          return this.$alert(error.response.data.message, 'error',true,5000)
        }
      });

      const reatedItems = rated.data.products.map(el=>el.id)

      const response = await axios(
          {
            url: env.rate_items,
            method: "get",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {});

        let unique = [];

        for(let i in response.data.orders) {
          response.data.orders[i].products.forEach((el) => {
            if(!unique.includes(el) && !reatedItems.includes(el)) unique.push(el)
          })
        }

        if(unique.length === 0) return;
        this.itemsToRate = (await axios.get(`${env.someItems}?products=${JSON.stringify(unique)}`)).data;
        console.log(this.itemsToRate)
    },
    async changePassword() {
      const response = await axios(
          {
            url: env.change_password,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`},
            data : {password: this.password2}
          }).catch((error) => {
        if (error.response) {
          return this.$alert(error.response.data.message, 'error',true,5000)
        }
      });

      if(!response) return;
    },
    removeItemToRate(x){
      this.itemsToRate.shift(x,1);
    }
  },
}
</script>

<style>

.noneRate {
  width:100%;
  text-align: center;
  margin-top: 50px;
  margin-bottom: 50px;
  color: rgba(80, 79, 79, 0.66);
  font-weight: 600;
  font-size: 20px;
}

.cfg-pass {
  background-color: #2f2f3c;
  border: none;
  width: 173px;
  border-radius: 3px;
  padding: 10px;
  box-shadow: inset 0 0px 10px rgb(0 0 0 / 30%);
  color: #cccccc;
}


.btn-cfg {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 173px;
  height: 30px;
  color: #cccccc;
  text-decoration: none;
  font-size: 14px;
  padding: 0 5px;
  margin-top: 4px;
  font-family: Arimo, sans-serif;
  vertical-align: middle;
  background-image: linear-gradient(to bottom,#083f50 40%, #152f4e 80%);
  box-shadow: 0px 1px 1px 0px rgb(0 0 0 / 80%);
  border: 1px solid #1a3056;
  border-radius: 8px;
}

.cfg-space  .cfg-value{
  padding: 50px;
  display: flex;
  flex-direction: column;
  grid-row-gap: 10px;
  align-items: center;
}

.content-box-account {
  width: calc(100% - 60px);
  margin-top: 20px;
  display: flex;
  justify-content: center;
  font-family: Arial;
  flex-direction: column;
  align-items: center;
}

.cfg-title {
  margin: 10px 0 10px 0;
  color: #908a8a;
  font-weight: 600;
  font-size: 18px;
  letter-spacing: 1px;
}

.cfg-box {
  width: 30%;
  height: 100%;
  background-color: #23232d;
  border-radius: 8px;
  padding: 10px 20px 0 20px;
  margin-bottom: 30px;
}

</style>