<template>
  <transition-group name="hideItem">
  <div class="item"
       :key="product.id"
       v-show="show"
   >

    <div class="form" v-if="form ? form.name==='fav' : false" @click="removeFav"><i class="fas fa-trash-alt"></i></div>
    <div class="form" v-if="form ? form.name==='home' : false" ><i class="fas fa-heart"></i></div>

    <div class="item-name">{{product.name}}</div>
    <router-link :to="{name:'Products',params:{id:product.id}}"><img :src="product.image" alt="" class="item-image"></router-link>
    <div class="item-desc">{{product.description}}</div>
    <div class="item-price">{{product.price}}zł</div>
    <div class="item-rate" v-html="rateHtml"></div>
  </div>

  </transition-group>

</template>

<script>
export default {
  name: "Item",
  props:['product','filters','form'],
  data() {
    return {
      rateHtml: ``,
      show: true,
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
    },
    removeFav() {
      this.$emit('removeFav',{productID : this.product.id})
    }
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
    }
  },
}
</script>

<style>

.form {
  position: absolute;
  opacity: .3;
}

.item {
  transition: all .5s;
}
.hideItem-enter-active {
  transform: scale(0.5);
  opacity: 1;
}

.hideItem-leave-active {
  transform: scale(0.8);
  opacity: 0;
}

.item-image{
  width: 250px;
  height: 250px;
  object-fit: contain;
  cursor: pointer;
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