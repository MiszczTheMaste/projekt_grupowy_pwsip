<template>
  <div class="cfg-box">
    <div class="cfg-title">Menu dodawania przedmiotu (Administrator)</div>
    <hr class="title-re">
  <div class="admin-menu-box">
    <br>
    <div class="tittle-admin">Nazwa przedmiotu</div>
    <input type="text"  v-model="data.name"/>
    <div class="tittle-admin">Zdjęcie produktu</div>
    <input type="text" v-model="data.image"/>
    <div class="tittle-admin">Mały opis</div>
    <input type="text" v-model="data.description"/>
    <div class="tittle-admin">Ilość przedmiotów</div>
    <input type="number" v-model="data.stock" />
    <div class="tittle-admin">Cena produktu</div>
    <input type="number" v-model="data.price" />
    <div class="tittle-admin">Statystyki produktu:</div>
    <div class="stats-box">
      <div class="desc-box" v-for="(i,index) in data.specs">
        <div class="desc-key">{{index}}</div>
        <div class="desc-value">{{data.specs[index]}}</div>
        <div class="desc-delete" @click="delete this.data.specs[index]">X</div>
      </div>
    </div>
    <button class="btn-cfg" @click="addStat">Dodaj statystyki</button>
    <br>
    <div class="tittle-admin">Typ produktu</div>
    <select class="select" v-model="data.categoryId">
      <option disabled value="9">Wybierz kategorię produktu</option>
      <option value="1">Monitory</option>
      <option value="2">Myszki</option>
      <option value="3">Klawiatury</option>
      <option value="4">Słuchawki</option>
      <option value="5">Karty Graficzne</option>
      <option value="6">Kamerki</option>
      <option value="0">Brak filtru</option>
    </select>
    <button class="btn-cfg" @click="createItem">Dodaj produkt do bazy</button>
  </div>
  </div>

  <div class="cfg-box">
    <div class="cfg-title">Menu edycji ilości (Administrator)</div>
    <hr class="title-re">
    <div class="box  admin-menu-box">
    <div class="tittle-admin">Ilość produktu</div>
    <input type="number" v-model="dataChangeAmount.count" />
      <div class="tittle-admin">ID produktu</div>
      <input type="number" v-model="dataChangeAmount.ID" />
      <button class="btn-cfg" @click="changeCount">Zmień ilość</button>
    </div>
  </div>

  <div class="cfg-box">
    <div class="cfg-title">Menu usuwania przedmiotu (Administrator)</div>
    <hr class="title-re">
    <div class="box  admin-menu-box">
      <div class="tittle-admin">ID produktu</div>
      <input type="number" v-model="dataRemoveItemID" />
      <button class="btn-cfg" @click="deleteItem">Usuń przedmiot</button>
    </div>
  </div>
</template>

<script>
import {computed} from "vue";
import env from "../assets/env";

export default {
  name: "AdminMenu",
  data() {
    return {
      test : 'siema',
      session : localStorage.getItem('jwt'),
      dataRemoveItemID : 0,
      dataChangeAmount:{
        ID : 0,
        count: 0,
      },
      data : {
        categoryId : 0,
        price : 0,
        description : '',
        image : '',
        name : '',
        specs : {},
        stock : 0,
      }
    }
  },
  methods: {
    remove(index) {
      console.log(index)
    },
    async createItem() {
      this.data.categoryId = +this.data.categoryId;

      const response = await axios(
          {
            url: `${env.create_item}`,
            method: "post",
            headers: {'Authorization': `Bearer ${this.session}`},
            data : this.data,
          }).catch((error) => {
        if (error.response) {
          this.status = 'error'
          return this.$alert("Wystąpił błąd podczas tworzenia przedmiotu!", 'error',true,5000)
        }
      });

      if(!response) return;

      return this.$alert(`Dodano przedmiot ${this.data.name} do bazy.`, 'success',true,5000)
    },
    async addStat() {
      const { value: formValues } = await this.$swal.fire({
        title: 'Dodaj statystyki',
        html:
            '<input id="swal-input1" class="swal2-input" placeholder="Nazwa">' +
            '<input id="swal-input2" class="swal2-input" placeholder="Opis">',
        focusConfirm: false,
        preConfirm: () => {
          return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value
          ]
        }
      })

      if (formValues) {
       let val = {};
       this.data.specs[formValues[0]] = formValues[1];
      }
    },

    async changeCount() {
      const response = await axios(
          {
            url: `${env.set_stock}/${this.dataChangeAmount.ID}/${this.dataChangeAmount.count}`,
            method: "patch",
            headers: {'Authorization': `Bearer ${this.session}`},
          }).catch((error) => {
        if (error.response) {
          this.status = 'error'
          return this.$alert("Wystąpił błąd podczas tworzenia przedmiotu!", 'error',true,5000)
        }
      });

      if(!response) return;

      return this.$alert(`Zaktualizowano pomyślnie ilość!.`, 'success',true,5000)
    },

    async deleteItem() {
      const response = await axios(
          {
            url: `${env.delete_item}/${this.dataRemoveItemID}`,
            method: "delete",
            headers: {'Authorization': `Bearer ${this.session}`},
          }).catch((error) => {
        if (error.response) {
          this.status = 'error'
          return this.$alert("Wystąpił błąd podczas tworzenia przedmiotu!", 'error',true,5000)
        }
      });

      if(!response) return;

      return this.$alert(`Usunięto przedmiot z bazy.`, 'success',true,5000)
    }
  },
}
</script>

<style scoped>

.desc-delete {
  cursor: pointer !important;
}

.btn-cfg {
  margin-top: 20px;
}

.stats-box {
  padding: 20px;
  width: 100%;
}

.tittle-admin {
  font-size: 18px;
  color: #cccccc;
}
.admin-menu-box {
  display:flex;
  align-items: center;
  flex-direction: column;
  padding: 20px;
}

input[type=text], input[type=number]{
  margin-bottom: 20px;
  background: transparent;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: 1px solid #7c7c7e;
  padding: 8px;
  color: #cccccc;
  font-weight: 600;
  text-align: center;
}
</style>