<template>
  <div class="item home-list-item"
       :key="product.id"
       v-show="show"
   >

    <div class="form"
         v-if="form ? form.name==='fav' : false"
         @click="removeFav"><i class="fas fa-trash-alt"></i>
    </div>

    <div class="form"
         v-if="form ? form.name==='home' : false"
         @click="favChange"
         :class="{'fav-item':product.fav}"><i class="fas fa-heart"></i>
    </div>

    <div class="item-name">{{product.name}}</div>
    <router-link :to="{name:'Products',params:{id:product.id}}"><img :src="product.image" alt="" class="item-image"></router-link>
    <div class="item-desc">{{product.description}}</div>
    <div class="item-price">{{product.price}}zł</div>
    <div class="item-rate" v-html="rateHtml"></div>
  </div>

</template>

<script>
export default {
  name: "Item",
  props:['product','filters','form',"filter"],
  data() {
    return {
      rateHtml: ``,
      show: true,
    }
  },
  methods: {
    calculateRate() {
      console.log(this.product)
      let rating = this.product.rating;
      for(let i=0;i<=4;i++) {
        if(rating>0) {
          this.rateHtml += ` <span class="fa fa-star checked"></span>`
          rating--;
          continue;
        };

        this.rateHtml += ` <span class="fa fa-star"></span>`
      }
    },
    removeFav() {
      this.$emit('removeFav',{productID : this.product.id})
    },
    favChange() {
      this.$emit('favChange',{productID : this.product.id})
    },
  },
  created() {
    this.calculateRate();
  },
  watch: {
    filters : {
      handler : function (value) {
        this.show = this.product.name.includes(value.findItemInput)
      },
      deep:true
    },
    filter : {
      handler : function (value) {
        this.show = value.priceMin <= this.product.price && value.priceMax >= this.product.price;
        if(value.typeItem !== this.product.categoryId && value.typeItem !== 9 && value.typeItem !== 0) this.show = false;
      },
      deep:true
    }
  },
}
</script>

<style>

.fas {
  cursor: pointer;
}

.home-list-item {
  transition: all 0.5s ease-in-out;
}

.home-list-enter-active {
  transform: scale(0.5);
  opacity: 0;
}

.home-list-leave-active {
  transform: scale(0.8);
  opacity: 0;
}


.home-list-enter-from,
.home-list-leave-to {
  transform: scale(0.8);
  opacity: 0;
}


.fav-item {
  color:red;
  opacity: 0.5 !important;
  animation: showAddFav 0.5s linear;
}

@keyframes showAddFav {
  0% {color:white;}
}


.form {
  position: absolute;
  opacity: .3;
}

.item {
  margin-left: 25px;
  display: flex;
  flex-direction: column;
  width: 300px;
  transition: all .3s;
  background-color: #1c1c24;
}

.item-image{
  width: 250px;
  height: 250px;
  object-fit: contain;
  cursor: pointer;
  margin-left: 25px;
}

.item {
  border: 1px solid rgba(124, 124, 126, 0.30);
  border-radius: 8px;
  padding: 15px;
  margin: 10px;
  height: 335px;
}

.item-name {
  text-align: center;
  font-weight: 600;
  font-family: arial;
  letter-spacing: 1px;
}

.item-price{
  margin-top: 10px;
  text-align: right;
  font-weight: 600;
  font-family: arial;
  letter-spacing: 1px;
  font-size: 15px;
}

.item-desc{
 color: #afafaf
}

</style>