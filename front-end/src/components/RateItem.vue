<template>
  <div class="rate-box">
  <div class="slider-box">
    <div class="left-skip skip"><i class="fas fa-play" @click="left_skip()" :style="buttonClickLeft"></i></div>
    <div class="slider-content">
      <div class="slider-items"  :style="sliderPosition">
        <Item
            v-for="item in products"
            :key = "item.id"
            :product="item"
            :form='{name:"rateItem"}'
            class="fav-list-item"
            :id="item.id"
        />
      </div>
    </div>
    <div class="right-skip skip"><i class="fas fa-play"  @click="right_skip()" :style="buttonClickRight"></i></div>
  </div>

    <select class="select" v-model="rate">
      <option disabled value="0">Wybierz ocenę produktu</option>
      <option value="1">Ocena : ★ (1)</option>
      <option value="2">Ocena : ★★ (2)</option>
      <option value="3">Ocena : ★★★ (3)</option>
      <option value="4">Ocena : ★★★★ (4)</option>
      <option value="5">Ocena : ★★★★★ (5) </option>
    </select>

  <button class="btn-cfg" @click="addRate">Oceń produkt</button>
  </div>
</template>

<script>
import Item from "../components/Item";
import env from "../assets/env";

export default {
  name: "RateItem",
  components: {Item},
  props : ['products'],
  data() {
    return {
      session : localStorage.getItem('jwt'),
      selectItem: 0,
      rate : 5,
      animationButtonLeft : false,
      animationButtonRight : false,
    }
  },
  computed: {
    sliderPosition() {
      return {'left':`-${this.selectItem* 537}px`};
    },
    buttonClickRight() {
      if(this.animationButtonRight) return {animation:'animationClick 0.5s ease-in-out'};
    },
    buttonClickLeft() {
      if(this.animationButtonLeft) return {animation:'animationClick 0.5s ease-in-out'};
    },
  },
  methods: {
    async addRate() {
      const itemRate = Object.values(this.products)[this.selectItem].id;

      const response = await axios(
          {
            url: `${env.create_reate}/${itemRate}/${this.rate}`,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`}
          }).catch((error) => {
        if (error.response) {
          return this.$alert(error.response.data.message, 'error',true,5000)
        }
      });

      if(!response) return;
      this.$emit('removeItem',this.selectItem)
      this.right_skip();
      return this.$alert("Dodano ocene produktu!", 'success',5000)
    },
    left_skip(){
      if(this.selectItem < this.products.length - 1)  {
        this.animationButtonLeft = true;
        this.selectItem++;
        setTimeout(()=>{
          this.animationButtonLeft = false;
        },500)
      }
    },
    right_skip(){
      if(this.selectItem > 0){
        this.animationButtonRight = true;
        this.selectItem--;
        setTimeout(()=>{
          this.animationButtonRight = false;
        },500)
      }
    }
  },
}
</script>

<style>


.slider-items img {
  margin-left: 20px;
  margin-right: 20px;
}

 .slider-items {
  display: flex;
   grid-gap: 200px;
   margin-left: 85px;
   position: relative;
   transition: 1s ease-in-out;
 }


  .rate-box{
  display: flex;
  align-items: center;
  flex-direction: column;
  padding:15px;
    overflow: hidden;
  }

  .slider-box {
    width:100%;
    height:100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-left: -30px;
  }

  .slider-content {
    width: 500px;
    height: 500px;
  }

  .skip {
    position: relative;
    height: 16px;
    font-size:25px;
    z-index: 4;
  }

  .left-skip {
    transform: rotate(180deg);
  }


  @keyframes animationClick {
    0% {transform: scale(0.5)}
  }

</style>