import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Form from "../views/login-form/Form";
import Basket from "../views/Basket";
import Fav from "../views/Fav";
import Product from '../views/Product';
import Account from "../views/Account";

const routes = [
  {
    path: "/home",
    name: "Home",
    component: Home,
    props : {filter:true},
  },
  {
    path: "/login",
    name: "Login",
    component: Form,
  },
  {
    path: "/basket",
    name: "Basket",
    component: Basket,
  },
  {
    path: "/favorite",
    name: "Favorite",
    component: Fav,
  },
  {
    path: "/products/:id",
    name: "Products",
    component: Product,
  },
  {
    path: "/account",
    name: "Account",
    component: Account,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
