<template>
  <img :src="product.image" class="product-image">
  <div class="basket-name">{{product.name}}</div>
  <div class="basket-price">{{product.price}}zł</div>
  <div class="basket-options">
    <transition name="removeItem">
      <i class="fas fa-trash-alt" @click="removeOrder"></i>
    </transition>
  </div>
</template>

<script>
export default {
  name: "BasketItem",
  props:['product'],
  data() {
    return {
      isFollowNow: this.product.follow
    }
  },
  methods: {
    removeOrder () {
      this.$emit('removeOrder',{productID : this.product.id})
    }
  },
}
</script>

<style>

.basket-price {
  width: 10%;
}

.basket-options i {
 cursor: pointer;
 font-weight: 300;
 transition: all 500ms;
 font-size: 20px;
 width: 10%;
 margin-right: 20px;
}

.product-image {
  width: 150px;
  height: 150px;
  object-fit: contain;
  cursor: pointer;
  width: 20%;
}

.basket-name {
  text-align: center;
  width: 60%;
}

@keyframes rotateItem {
  25% {transform: rotate(-20deg);}
  50% {transform: rotate(20deg);}
}

@keyframes removeItem {
  25% {width: 0px}
  50% {transform: rotate(20deg);}
}

</style>