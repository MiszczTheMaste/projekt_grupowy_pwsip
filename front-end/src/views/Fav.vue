<template>
  <div class="content-box">
    <div class="product-title title-fav">Ulubione przedmioty</div>
    <hr class="title-re">


    <div class="item-list-fav" >
      <div v-if="itemList.length === 0" class="empty-fav">Lista ulubionych jest pusta</div>
      <Item
          v-for="item in itemList"
          :key = "item.id"
          :product="item"
          :filters="filters"
          :form='{name:"fav"}'
          @removeFav="removeFav"
      />
    </div>
  </div>

</template>

<script>
import Item from "../components/Item";
import Filter from "../components/Filter";

export default {
  name: "Fav",
  props: ['filters'],
  components: {Item},
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
  methods: {
    removeFav({productID}) {
      const removeItemIndex = this.itemList.findIndex(item => item.id === productID);
      this.itemList.splice(removeItemIndex,1)
    }
  },
}
</script>

<style>

.empty-fav {
  width: 100%;
  font-family: Arial;
  font-size: 25px;
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