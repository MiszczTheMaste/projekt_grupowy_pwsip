<template>
  <div class="home" v-if="loadInits">
    <Filter
        @filterChange = 'filterChange'
    />

    <div class="item-list" >
      <transition-group name="home-list">
      <Item
          v-for="item in itemList"
          :key = "item.id"
          :product="item"
          :filters="filters"
          :filter = "filter"
          :form='{name:"home"}'
          class="home-list-item"
          @favChange="favChange"
       />
      </transition-group>
    </div>

  </div>

  <transition name="fade">
    <Loader v-if="!loadInits" key="homeLoader"></Loader>
  </transition>

</template>

<script>
import Filter from "../components/Filter";
import Item from "../components/Item";
import Loader from "../components/Loader";
import {filter} from "core-js/internals/array-iteration";
const env = require('../assets/env');

export default {
  name: 'Home',
  props:['filters'],
  components: {Item, Filter,Loader},
  data() {
    return {
      loadInits : false,
      itemList: [],
      favItems: this.getStorage('fav-storage'),
      filter : {
        priceMin: 0,
        priceMax: 50_000,
        typeItem : 0,
      }
    }
  },
  beforeMount() {
    this.loadAllItems();
  },
  methods: {
    filterChange({key,value}) {
      console.log(key,value)
      this.filter[key] = value;
    },
    favChange({productID}) {
      const itemIndex = this.itemList.findIndex(item => item.id === productID);
      const storage = this.getStorage('fav-storage');

      if(!storage.includes(productID)) {
        storage.push(productID)
        this.$alert('Dodawno do ulubionych!','success')
        this.setStorage('fav-storage',storage);
      }else {
        this.$alert('Usunięto z ulubionych!','success')
        storage.splice(storage.indexOf(productID),1);
        this.setStorage('fav-storage',storage);
      }

      this.itemList[itemIndex]['fav'] = !this.itemList[itemIndex]['fav'];
      console.log(this.itemList)
    },

    setStorage(key,value) {
      localStorage.setItem(key,JSON.stringify(value))
    },

    getStorage(key) {
      if(!localStorage.getItem(key)) this.setStorage(key,[])
      return JSON.parse(localStorage.getItem(key));
    },

    async loadAllItems() {
      const response = await axios.get(env.allProducts,{headers : {"Access-Control-Allow-Origin": "*"}});
      this.itemList = response.data;
      this.loadInits = true;

      this.favItems.forEach(el=>{
        let itemIndex = this.itemList.findIndex(item => item.id === el);
        if(this.itemList[itemIndex]) this.itemList[itemIndex]['fav'] = true;
      });
    }

  },
}

</script>

<style>


 @keyframes homeSpin {
   0% {transform:rotate(-360deg)}
 }
  .home{
    display: flex;
    flex-direction: row;
  }
  .item-list {
    width: 100%;
    height: calc(100vh - 80px);
    background-color: #23232d;
    margin: 10px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    grid-gap: 10px;
    justify-content: center;
    align-items: center;
    justify-content: center;
    border-radius:8px;
    overflow-x: hidden;
  }

</style>