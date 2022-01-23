<template>
  <div class="product-box" v-if="loadInits">
  <a @click="$router.go(-1)" id="backButton"><i class="fas fa-long-arrow-alt-left"></i></a>

  <div class="product-info">

  <div class="left-bar">

    <div class="image-container">
      <div class="product-title">Zdjęcie produktu</div>
       <hr class="title-re">
      <img :src="product.image">
    </div>

  </div>

    <div class="left-bar">

      <div class="image-container">
        <div class="product-title">Dane techniczne</div>
        <hr class="title-re">

        <div class="product-full-name">
          {{product.name}}
        </div>

        <div class="item-rate rate" v-html="rateHtml"></div>

        <div class="desc-lane">
          Cena przedmiotu: <b>{{product.price}}zł</b>
        </div>

        <div class="desc-lane">
          Pozdostało sztuk: <b>{{product.stock}}</b>
        </div>

        <div class="desc-lane">
          Ocena użytkowników: <b>{{product.rating.toFixed(2)}}</b>
        </div>

        <div class="desc-lane">
          Czas dostawy: <b>2 dni  - 7 dni</b>
        </div>

        <div class="desc-lane">
          Opis produktu: <b>{{product.description}}</b>
        </div>

        <button class="btn-blue" id="addToBasket" @click="addToBasket" v-if="product.stock !== 0">Dodaj do koszyka</button>
        <button class="btn-blue" id="sold" disabled v-if="product.stock == 0">Produkt wyprzedany!</button>
      </div>

    </div>

  </div>

  <div class="full-desc">
    <div class="product-title">Specyfikacja</div>
    <hr class="title-re">

    <div class="content-desc">

      <div class="desc-box" v-for="(item,index) in product.specs">
        <div class="desc-key">{{index}}</div>
        <div class="desc-value">{{product.specs[index]}}</div>
      </div>

    </div>

  </div>
  </div>

  <transition name="fade">
    <Loader v-if="!loadInits" key="productLoader"></Loader>
  </transition>

</template>

<script>
const env = require('../assets/env');
import Loader from "../components/Loader";

export default {
  name: "Product",
  components: {Loader},
  data() {
    return {
      loadInits : false,
      productID: +this.$route.params.id,
      product : null,
      rateHtml: ``,
    }
  },
  created() {
    this.loadProduct();
  },
  methods: {
    setStorage(key,value) {
      localStorage.setItem(key,JSON.stringify(value))
    },

    getStorage(key) {
      if(!localStorage.getItem(key)) this.setStorage(key,[])
      return JSON.parse(localStorage.getItem(key));
    },

    calculateRate() {
      let stars = this.product.rating;
      for(let i=0;i<=4;i++) {
        if(stars>0) {
          this.rateHtml += ` <span class="fa fa-star checked"></span>`
          stars--;
          continue;
        };

        this.rateHtml += ` <span class="fa fa-star"></span>`
      }
    },

    async loadProduct() {
      const response = await axios.get(`${env.product}/${this.productID}`);
      this.product = response.data;
      this.calculateRate();
      this.loadInits = true;
    },

    addToBasket() {
      const storage = this.getStorage('basket-storage');

      if(!storage.includes(this.productID)) {
        storage.push(this.productID)
        this.$alert('Dodano do koszyka!','success')
        this.setStorage('basket-storage',storage);
        this.$emit('changeBasketAmount',1);
      }else {
        this.$alert('Przedmiot jest już w koszyku!','error')
      }

    }
  },
}
</script>

<style>

#addToBasket {
  margin-top: 20px;
}

.desc-box:nth-child(2n+1) {
  background: hsl(240deg 8% 23% / 32%);
}

.content-desc {
  margin-top: 20px;
}

.desc-box {
  display: flex;
  flex-direction: column;;
  padding: 15px;
  align-items: center;
  justify-content: space-evenly;
  grid-gap: 10px;
}

.desc-key {
  color: #d07426;
  font-size: 20px;
  position: relative;
  font-weight: 600;
}


.desc-value {
  font-size: 20px;
}


.full-desc {
  width: calc(100% - 60px);
  height: auto;
  min-height: 300px;
  background-color: #23232d;
  margin:50px 10px 10px 10px;
  padding: 20px;
}

.image-container img {
 object-fit: contain;
 width: 100%;
 height: 100%;
 max-height: 300px;
}

#addToBacket {
  margin-top: 20px;
  position: relative;
}

.rate {
  margin-bottom: 20px;
}

.item-rate span {
  font-weight: 300;
}

.checked {
  color: #d07426;
  font-weight: 600 !important;
}

.show-details {
  margin-top: 30px;
}

.show-details i{
  color: #d07426;
  margin-left: 2px;
}

.desc-lane b {
  font-weight: 600;
  font-family: system-ui;
  font-size: 15px;
  color: #d07426;
}

.product-full-name {
  font-weight: 600;
  text-align: center;
  font-size: 15px;
  margin-bottom: 20px;
}

.title-re {
  opacity: 0.1;
  width: 100%;
}

#sold {
  margin-top: 25px;
}
.product-info {
  display: flex;
  justify-content: space-around;
}

.product-title {
  font-size: 20px;
  text-align: center;
  font-family: Arial;
  letter-spacing: 2px;
}

#backButton {
  position: relative;
  cursor: pointer;
  margin: 10px;
  font-size: 25px;
  top: 10px;

}

.left-bar {
  width: 500px;
  padding: 20px;
  margin-left: 10px;
  margin-top: 15px;
  background-color: #23232d;
  height: 100%;
  border-radius: 8px;
}
</style>