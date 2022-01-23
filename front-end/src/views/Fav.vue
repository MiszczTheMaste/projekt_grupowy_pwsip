<template>
  <div class="content-box" v-if="loadInits">
    <div class="product-title title-fav">Ulubione przedmioty</div>
    <hr class="title-re">

    <div class="item-list-fav" >
      <div v-if="itemList.length === 0" class="empty-fav">Lista ulubionych jest pusta</div>
      <transition-group name="fav-list">
      <Item
          v-for="item in itemList"
          :key = "item.id"
          :product="item"
          :filters="filters"
          :form='{name:"fav"}'
          class="fav-list-item"
          @removeFav="favChange"
      />
      </transition-group>
    </div>
  </div>

  <transition name="fade">
    <Loader v-if="!loadInits" key="homeLoader"></Loader>
  </transition>

</template>

<script>
import Item from "../components/Item";
import Loader from "../components/Loader";
import env from "../assets/env";

export default {
  name: "Fav",
  props: ['filters'],
  components: {Item,Loader},
  data() {
    return {
      storage : this.getStorage('fav-storage') ? JSON.parse(localStorage.getItem('fav-storage')) : null,
      loadInits: false,
      itemList: []
    }
  },
  beforeMount() {
    this.loadFavItems()
  },
  methods: {
    favChange({productID}) {
      const itemIndex = this.itemList.findIndex(item => item.id === productID);
      const storage = this.getStorage('fav-storage');

      if(storage.includes(productID)) {
        this.$alert('Usunięto z ulubionych!','success')
        storage.splice(storage.indexOf(productID),1);
        this.setStorage('fav-storage',storage);
      }

      this.itemList.splice(itemIndex,1)
    },

    setStorage(key,value) {
      localStorage.setItem(key,JSON.stringify(value))
    },

    getStorage(key) {
      if(!localStorage.getItem(key)) this.setStorage(key,[])
      return JSON.parse(localStorage.getItem(key));
    },


    async loadFavItems() {
      if(!this.storage) return;

      const response = await axios.get(`${env.someItems}?products=${JSON.stringify(this.storage)}`)
      this.itemList = response.data;
      this.loadInits = true;
    },
  },

}
</script>

<style>

.fav-list-leave-active {
  position:absolute;
  transform: scale(0.8);
  opacity: 0;
  transition: .5s ease-in-out;
}

.empty-fav {
  position:absolute;
  width: calc(100vw - 150px);
  font-family: Arial;
  font-size: 30px;
  text-align: center;
  padding: 50px;
  opacity: .2;
  user-select: none;
}

.item-list-fav {
  width: 100%;
  background-color: #23232d;
  margin: 20px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  grid-gap: 10px;
  min-height: 390px;
  align-items: center;
}

  .content-box hr{
    margin: 20px;
  }

  .title-fav {
    margin-top: 20px;
  }

  .content-box{
  width: calc(100% - 20px);
  background-color: #23232d;
  margin: 10px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
}

</style>