<template>
  <div class="product-title">Opłać zamówienie</div>
  <hr class="title-re">

  <div class="blik-main-box">
  <div class="blik-container">
    <div class="blik-payment">
      <label v-show="status==='waiting'">Wpisz kod BLIK</label>
      <img src="https://contests.allegrostatic.com/banks/logos2/blik-alias_on.png" v-show="status==='waiting'">
      <input type="text" maxlength="7" v-show="status==='waiting'" v-model="blikCode"/>
      <button class="btn-cfg" v-show="status==='waiting'" @click="payM">Zapłać</button>
      <div v-show="status==='loading'">Potwierdz kod w swoim banku</div>
      <i class="fas fa-spinner" v-if="status === 'loading'"></i>


      <div class="payment-success" v-if="status==='success'">
        <div>Płatność powiodła się!</div><br>
        <i class="fas fa-check-circle"></i>
        <button class="btn-cfg" @click="this.$router.push({name:'Home'})">Zakończ</button>
      </div>

      <div class="payment-error" v-if="status==='error'">
        <div>Płatność nie powiodła się!</div><br>
        <i class="fas fa-times-circle"></i>
        <button class="btn-cfg" @click="status='waiting'">Ponów płatność</button>
      </div>

    </div>
  </div>
  </div>

</template>

<script>
import env from "../assets/env";

export default {
  name: "Blik",
  data() {
    return {
      status: 'waiting',
      blikCode : '',
      session : localStorage.getItem('jwt'),
    }
  },
  watch :{
    blikCode : function (newvalue,oldvalue) {
      if(newvalue.length === 3 && oldvalue.length < newvalue.length) {
        console.log('Space')
        return this.blikCode+=' ';
      }
    }
  },
  methods: {
    payM() {
      this.status = 'loading';
      setTimeout(async ()=>{
        if(this.blikCode.replaceAll(' ','')!= '444444') {
          return this.status = 'error'
        }

        const response = await axios(
            {
              url: `${env.buy_succeed}?products=${localStorage.getItem('basket-storage')}`,
              method: "post",
              headers: {'Authorization': `Bearer ${this.session}`},
            }).catch((error) => {
          if (error.response) {
            this.status = 'error'
            return this.$alert("Wystąpił błąd podczas zakupów!", 'error',true,5000)
          }
        });

        localStorage.removeItem('basket-storage')

        this.sessionStatus = false;
        if(!response) return;
        this.template = 'payment';

        return this.status = 'success';
      },4000)
    }
  },
}
</script>

<style>
.blik-main-box {
  display:flex;
  width:100%;
  height:100%;
  justify-content: center;
  align-items: center;
  margin-bottom: 150px;
}
.blik-container {
  display:flex;
  width: 400px;
  height: 400px;
  background-color: #1c1c24;
  justify-content: center;
  align-items: center;
  border: 1px solid rgba(124, 124, 126, 0.30);
  border-radius: 8px;
}
.blik-payment,.payment-success,.payment-error {
  flex-direction: column;
  justify-content: center;
  align-items: center;
  grid-gap: 25px;
  display:flex;
}
.fa-check-circle {
  color: green;
}

.fa-times-circle {
  color: #791010;
}
.blik-payment img{
  width: 50px;
}

.blik-payment i {
  font-size: 40px
}

.blik-container input {
  margin-bottom: 20px;
  background: transparent;
  border: 1px solid #7c7c7e;
  padding: 8px;
  color: #cccccc;
  font-weight: 600;
  text-align:center;
}
</style>