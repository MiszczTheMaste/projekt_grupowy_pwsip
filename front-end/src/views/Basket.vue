<template>
 <div class="basket-content">

   <div class="basket-left">
     <div class="product-title">Lista produktów w koszyku</div>
     <hr class="title-re">

     <transition-group name="removeItem" tag="div" id="item-list">
     <div v-for="(item,index) in itemList" class="basket-item" :key="item.id">
       <BasketItem :product="item" :key="item.id" @removeOrder="removeItem"/>
     </div>
     </transition-group>

   </div>

  <div class="basket-right">

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

    <button class="btn-blue buy-now">Zapłać teraz</button>
  </div>

 </div>

</template>

<script>
import BasketItem from "../components/BasketItem";

export default {
  name: "Basket",
  components: {BasketItem},
  data() {
    return {
      itemList: [
        {id:3,name:'Monitor AOC G24C',price:2000,description:'Opis produktu',image:'https://i.imgur.com/KX85BtQ.png',stars:5},
        {id:4,name:'Podkładka StealSeries',price:2000,description:'Podkładka opis',image:'https://i.imgur.com/8T9iGk6.png',stars:1},
        {id:5,name:'Klawiatura X',price:2000,description:'Opis klawiatura',image:'https://i.imgur.com/i3lvSXe.png',stars:3},
        {id:6,name:'Monitor',price:2000,description:'Opis produktu',image:'https://i.imgur.com/bvduK5A.png',stars:2},
      ]
    }
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
      const removeItemIndex = this.itemList.findIndex(item => item.id === productID);
      this.itemList.splice(removeItemIndex,1)
    }
  },
}
</script>

<style>


.removeItem-enter-active {
  transform: scale(1);
  opacity: 0;
  transition: 1s;
}

.removeItem-leave-active {
  transform: scale(0.8);
  opacity: 0;
  transition: 1s;
}

.basket-item div,.basket-item i,.basket-item img{
  padding: 10px;
}

.basket-item {
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