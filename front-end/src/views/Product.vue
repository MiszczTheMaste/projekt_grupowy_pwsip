<template>
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
          Karta graficzna Gigabyte GeForce GTX 1660Ti OC 6GB GDDR6 (GV-N166TOC-6GD)
        </div>

        <div class="item-rate rate" v-html="rateHtml"></div>

        <div class="desc-lane">
          Długość karty: <b>265 mm</b>
        </div>

        <div class="desc-lane">
          Ilość pamięci RAM: <b>6 GB</b>
        </div>

        <div class="desc-lane">
          Rodzaj chipsetu: <b>GeForce GTX 1660 Ti</b>
        </div>

        <div class="desc-lane">
          Taktowanie rdzenia w trybie boost: <b>1800 MHz</b>
        </div>

        <div class="desc-lane">
          Łączenie kart: <b>Nie</b>
        </div>

        <button class="btn-blue" id="addToBacket">Dodaj do koszyka</button>
      </div>

    </div>

  </div>

  <div class="full-desc">
    <div class="product-title">Specyfikacja</div>
    <hr class="title-re">

    <div class="content-desc">

      <div class="desc-box">
        <div class="desc-key">Procesor</div>
        <div class="desc-value">MediaTek Dimensity 1200 (1 rdzeń, 3,0 GHz, A78 + 3 rdzenie, 2,6 GHz, A78 + 4 rdzenie, 2.0 GHz, A55</div>
      </div>

      <div class="desc-box">
        <div class="desc-key">Procesor</div>
        <div class="desc-value">MediaTek Dimensity 1200 (1 rdzeń, 3,0 GHz, A78 + 3 rdzenie, 2,6 GHz, A78 + 4 rdzenie, 2.0 GHz, A55</div>
      </div>

      <div class="desc-box">
        <div class="desc-key">Procesor</div>
        <div class="desc-value">MediaTek Dimensity 1200 (1 rdzeń, 3,0 GHz, A78 + 3 rdzenie, 2,6 GHz, A78 + 4 rdzenie, 2.0 GHz, A55</div>
      </div>

      <div class="desc-box">
        <div class="desc-key">Procesor</div>
        <div class="desc-value">MediaTek Dimensity 1200 (1 rdzeń, 3,0 GHz, A78 + 3 rdzenie, 2,6 GHz, A78 + 4 rdzenie, 2.0 GHz, A55</div>
      </div>


      <div class="desc-box">
        <div class="desc-key">Procesor</div>
        <div class="desc-value">MediaTek Dimensity 1200 (1 rdzeń, 3,0 GHz, A78 + 3 rdzenie, 2,6 GHz, A78 + 4 rdzenie, 2.0 GHz, A55</div>
      </div>


    </div>

  </div>

</template>

<script>
export default {
  name: "Product",
  data() {
    return {
      productID: this.$route.params.id,
      product : null,
      rateHtml: ``,
      itemList: [
        {id:1,name:'Karta graficzna',price:2000,description:'Karta graficzna opis',image:'https://i.imgur.com/9SkMSGn.png',stars:4},
        {id:3,name:'Monitor AOC G24C',price:2000,description:'Opis produktu',image:'https://i.imgur.com/KX85BtQ.png',stars:5},
        {id:4,name:'Podkładka StealSeries',price:2000,description:'Podkładka opis',image:'https://i.imgur.com/8T9iGk6.png',stars:1},
        {id:5,name:'Klawiatura X',price:2000,description:'Opis klawiatura',image:'https://i.imgur.com/i3lvSXe.png',stars:3},
        {id:6,name:'Monitor',price:2000,description:'Opis produktu',image:'https://i.imgur.com/bvduK5A.png',stars:2},
        {id:7,name:'Iphone X',price:2000,description:'Opis tele',image:'https://i.imgur.com/pf0SEL2.png',stars:5},
        {id:8,name:'Myszka ',price:2000,description:'Opis mysz',image:'https://i.imgur.com/vKHAHJY.png',stars:3},
        {id:10,name:'Kamerka Logitech',price:12000,description:'kamerka',image:'https://i.imgur.com/Lwxa8Jo.png',stars:5}
      ]
    }
  },
  methods: {
    calculateRate() {
      let stars = this.product.stars;
      for(let i=0;i<=4;i++) {
        if(stars>0) {
          this.rateHtml += ` <span class="fa fa-star checked"></span>`
          stars--;
          continue;
        };

        this.rateHtml += ` <span class="fa fa-star"></span>`
      }
    }
  },
  created() {
      this.product = this.itemList.find((el)=> {return el.id===+this.productID});
      this.calculateRate();
  },
}
</script>

<style>

.desc-box:nth-child(2n+1) {
  background: hsl(240deg 8% 23% / 32%);
}

.content-desc {
  margin-top: 20px;
}

.desc-box {
  display: flex;
  flex-direction: row;
  padding: 15px;
  align-items: center;
  justify-content: space-evenly;
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