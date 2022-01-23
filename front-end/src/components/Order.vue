<template>
  <div class="order">
    <div class="product-title">Dane odbiorcy przesyłki</div>
    <hr class="title-re">
    <div class="tittle-order">Imie</div>
    <input type="text" />
    <div class="tittle-order">Nazwisko</div>
    <input type="text" />
    <div class="tittle-order">Miasto</div>
    <div class="tittle-small">Na ten adres zostanie wysłana Twoja przesyłka.</div>
    <input type="text" class="" />
    <div class="tittle-order">Ulica</div>
    <input type="text" class="" />
    <div class="tittle-order">Kod pocztowy</div>
    <input type="text" />
  </div>

  <div class="order">
    <div class="product-title">Zamówione produkty</div>
    <hr class="title-re">
    <transition-group name="removeItem" tag="div" id="item-list">
      <div v-for="(item,index) in itemList" class="basket-item" :key="item.id">
        <BasketItem :product="item" :key="item.id" @removeOrder="removeItem"/>
      </div>
    </transition-group>
  </div>

  <div class="order">
    <div class="product-title">Sposób dostawy</div>
    <hr class="title-re">
    <div class="tittle-small">Przesyłka dostanie dostarczona od 2 do 5 dni roboczych.</div>
    <p>
      <input type="radio" name="radio" checked/>
      <span>Paczkomat InPost (8,99 zł)</span>
    </p>
    <p>
      <input type="radio" name="radio"/>
      <span>Orlen (6,70 zł)</span>
    </p>
    <p>
      <input type="radio" name="radio"/>
      <span>Automat ORLEN Paczka (6,70 zł)</span>
    </p>
    <p>
      <input type="radio" name="radio"/>
      <span>Poczta Polska (9,70 zł)</span>
    </p>
    <p>
      <input type="radio" name="radio"/>
      <span>Żabka (9,70 zł)</span>
    </p>
  </div>

  <div class="order">
    <div class="product-title">Metoda płatnopści</div>
    <hr class="title-re">

    <div class="blik-box checkedPayment">
      <img src="https://contests.allegrostatic.com/banks/logos2/blik-alias_on.png">
       <span>BLIK</span>
    </div>

    <div class="blik-box">
      <img src="https://contests.allegrostatic.com/banks/logos2/mastercard_on.png">
      <span>Karta płatnicza</span>
    </div>

    <div class="blik-box">
      <img src="https://assets.allegrostatic.com/metrum/icon/cash-transfer-b5f62469fa.svg">
      <span>Przelew</span>
    </div>
  </div>

</template>

<script>
import BasketItem from "./BasketItem";

export default {
  name: "Order",
  components : {BasketItem},
  props : ['itemList'],
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

  },
}
</script>

<style>


.blik-box{
  margin-top: 25px;
  width: 300px;
  display:flex;
  align-items:center;
  padding: 10px;
  border:2px solid rgb(82 82 82);
}

.checkedPayment {
  border:2px solid rgba(0, 128, 0, 0.51);
}

.blik-box img{
  height: 25px;
  width: auto;
  margin-right: 25px;
}

.order p {
 display:flex;
 align-items: center;
}

.order p span {
  margin-top: 3px;
}

input[type="radio"] {
  appearance: none;
  margin-right:10px;
  width: 20px;
  height: 20px;
  border: 1px solid #413f3f;
  border-radius: 50%;
  background-clip: content-box;
  padding: 3px;
}

input[type="radio"]:checked {
  background-color: #706d6d;
  border-radius: 50%;
}

input
.order{
  position: relative;
}

.tittle-small {
  color: #676565;;
  font-size: 10px;
}


.tittle-order {
  color: #a69f9f;
  font-size:20px;
}

.order input[type=text] {
  margin-bottom: 20px;
  background: transparent;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: 1px solid #7c7c7e;
  padding: 8px;
  color: #cccccc;
  font-weight: 600;
}
</style>