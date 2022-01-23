<template>
 <div class="basket-content" v-if="loadInits">

   <div class="basket-left" v-if="!template">
     <div class="product-title">Lista produktów w koszyku</div>
     <hr class="title-re">

     <transition-group name="removeItem" tag="div" id="item-list">
     <div v-for="(item,index) in itemList" class="basket-item" :key="item.id">
       <BasketItem :product="item" :key="item.id" @removeOrder="removeItem"/>
     </div>
     </transition-group>
   </div>


   <div class="basket-left" v-if="template === 'payment'">
      <Order :itemList = 'itemList'></Order>
   </div>

   <div class="basket-left" v-if="template==='blik'">
     <Blik :itemList = 'itemList' :price="totalPrice.totalWithVat" v-if="template === 'blik'"></Blik>
   </div>


   <div class="basket-right" v-if="template !== 'blik'">

    <div class="product-title">Wartość koszyka</div>
    <hr class="title-re">

    <div class="desc-lane">
      Przedmiotów w koszyku: <b>{{itemList.length}}</b><br>
    </div>

    <div class="desc-lane">
      Całkowita suma netto: <b>{{totalPrice.total}}zł</b>
    </div>


    <div class="desc-lane">
      Całkowita suma brutto: <b>{{totalPrice.totalWithVat}}zł</b>  (23% VAT)
    </div>

    <button class="buy-now" v-if="!template" @click="checkSession">
      <div v-if="!sessionStatus">Złóż zamównie</div>
      <div v-if="sessionStatus"><i class="fas fa-spinner"></i></div>
    </button>

    <button class="buy-now" v-if="template" @click="goToBlik">Opłać zamówienie</button>
  </div>

 </div>

  <transition name="fade">
    <Loader v-if="!loadInits" key="homeLoader"></Loader>
  </transition>

</template>

<script>
import BasketItem from "../components/BasketItem";
import Loader from "../components/Loader";
import Order from "../components/Order";
import Blik from "../components/Blik";
import env from "../assets/env";


export default {
  name: "Basket",
  components: {BasketItem,Loader,Order,Blik},
  data() {
    return {
      sessionStatus: false,
      session : localStorage.getItem('jwt'),
      username : null,
      template: '',
      storage : this.getStorage('basket-storage') ? JSON.parse(localStorage.getItem('basket-storage')) : null,
      loadInits :false,
      itemList: []
    }
  },
  beforeMount() {
    this.loadBasketItems()
  },
  computed: {
    totalPrice() {
      const totalPrice = this.itemList.map(el=>el.price).reduce((a, b) => a + b, 0);

      return {
        total: (totalPrice).toFixed(2),
        totalWithVat: (totalPrice + totalPrice *0.23).toFixed(2)
      }
    }
  },
  methods: {
    removeItem({productID}) {
      const itemIndex = this.itemList.findIndex(item => item.id === productID);
      const storage = this.getStorage('basket-storage');

      if(storage.includes(productID)) {
        this.$alert('Usunięto z koszyka!','success')
        storage.splice(storage.indexOf(productID),1);
        this.setStorage('basket-storage',storage);
      }

      this.$emit('changeBasketAmount',-1);
      this.itemList.splice(itemIndex,1)
    },

    setStorage(key,value) {
      localStorage.setItem(key,JSON.stringify(value))
    },

    getStorage(key) {
      if(!localStorage.getItem(key)) this.setStorage(key,[])
      return JSON.parse(localStorage.getItem(key));
    },

    async loadBasketItems() {
      const response = await axios.get(`${env.someItems}?products=${JSON.stringify(this.storage)}`)
      this.itemList = response.data;
      this.loadInits = true;
    },

    goToBlik() {
      if(this.itemList.length === 0)  {
        this.template = '';
        return this.$alert("Twój koszyk jest pusty!", 'error',)
      }

      this.template='blik'
    },

    async checkSession() {
      if(this.itemList.length === 0)  {
        return this.$alert("Twój koszyk jest pusty!", 'error',)
      }

      if(this.sessionStatus) return;
      this.sessionStatus = true;

      const response = await axios(
          {
            url: env.session,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {
        if (error.response) {
          localStorage.removeItem('jwt');
          return this.$alert("Nie jesteś zalogowany, zaloguj się aby zakupić przedmioty!", 'error',true,5000)
        }
      });

      this.sessionStatus = false;
      if(!response) return;
      this.template = 'payment';
    },
  },
}
</script>

<style>


.removeItem-leave-active {
  transform: scale(0.8);
  opacity: 0;
  transition: 0.5s;
}

.basket-item div,.basket-item i,.basket-item img{
  padding: 10px;
}
.buy-now{
  background: rgb(58 130 239);
  border: 2px solid rgb(58 130 255);
  border-radius: 8px;
  padding: 8px;
  color: #23232d;
  font-weight: 600;
  text-transform: uppercase;
  cursor: pointer;
}

.basket-item {
  background-color: #1c1c24;
  display: flex;
  justify-items: center;
  align-items: center;
  border: 1px solid rgba(255, 255, 255, 0.24);
  margin: 10px;
  border-radius: 8px;
  font-family: Arial;
  font-size: 17px;
  justify-content: flex-end;
}

.buy-now {
  margin-top: 30px;
}
.basket-right .desc-lane {
  margin-top: 10px;
  font-size: 16px;
}

.basket-content {
  width: calc(100vw - 40px);
  margin: 20px;
  display: flex;
}

.basket-left {
  background-color: #23232d;
  width: 100%;
  min-height: 200px;
  margin-right: 40px;
  overflow: hidden;
}

.basket-right {
  position: -webkit-sticky;
  position: sticky;
  top: 20px;
  background-color: #23232d;
  width: 20%;
  height: 100%;
  display: flex;
  flex-direction: column;
}


.basket-right,.basket-left{
  padding: 10px;
  border-radius: 8px;
}

</style>