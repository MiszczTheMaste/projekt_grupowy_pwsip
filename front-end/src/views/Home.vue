<template>
  <div class="home">
    <Filter/>


    <div class="item-list" >
      <Item v-for="item in itemList" :key = "item.id" :product="item" :filters="filters" :form='{name:"home"}'/>
    </div>

  </div>
</template>

<script>
import Filter from "../components/Filter";
import Item from "../components/Item";

export default {
  name: 'Home',
  props:['filters'],
  components: {Item, Filter},
  data() {
    return {
      itemList: [
        {id:1,name:'Karta graficzna',price:2000,description:'Karta graficzna opis',image:'https://i.imgur.com/9SkMSGn.png',stars:4},
        {id:3,name:'Monitor AOC G24C',price:2000,description:'Opis produktu',image:'https://i.imgur.com/KX85BtQ.png',stars:5},
        {id:4,name:'Podkładka StealSeries',price:2000,description:'Podkładka opis',image:'https://i.imgur.com/8T9iGk6.png',stars:1},
        {id:5,name:'Klawiatura X',price:2000,description:'Opis klawiatura',image:'https://i.imgur.com/i3lvSXe.png',stars:3},
        {id:6,name:'Monitor',price:2000,description:'Opis produktu',image:'https://i.imgur.com/bvduK5A.png',stars:2},
        {id:7,name:'Iphone X',price:2000,description:'Opis tele',image:'https://i.imgur.com/pf0SEL2.png',stars:5},
        {id:8,name:'Myszka ',price:2000,description:'Opis mysz',image:'https://i.imgur.com/vKHAHJY.png',stars:3},
        {id:10,name:'Kamerka Logitech',price:12000,description:'kamerka',image:'https://i.imgur.com/Lwxa8Jo.png',stars:5}
      ],
    }
  },
}

</script>

<style>

  .home{
    display: flex;
    flex-direction: row;
  }
  .item-list {
    width: 100%;
    height: auto;
    background-color: #23232d;
    margin: 10px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    grid-gap: 10px;
    justify-content: center;
    align-items: center;
    justify-content: center;
    overflow-x: hidden;
  }

</style>