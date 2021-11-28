<template>
  <Login v-if = 'template === "login"' @changeForm = 'changeForm'/>
  <Register v-if = 'template === "register"' @changeForm = 'changeForm'/>
</template>

<script>
import Register from "@/views/login-form/Register";
import Login from "@/views/login-form/Login";

export default {
  components:{Register,Login},
  data() {
    return {
      template: 'login',
    }
  },
  methods: {
    changeForm(value) {
      this.template = value;
    }
  },
}
</script>

<style>
#login-form {
  position: relative;
  top: 200px;
  width: 300px;
  height: auto;
  display: flex;
  margin: 0 auto;
  background-color: #23232d;
  justify-content: center;
  padding: 20px;
  flex-direction: column;
  border-radius: 8px;
}

#login-form label{
  color: #908a8a;
  font-size: 20px;
}

#login-form input{
  margin-bottom: 20px;
  background: transparent;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: 1px solid #7c7c7e;
  padding: 8px;
  color: #cccccc;
  font-weight: 600;
}

#login-form button{
  background: rgb(58 130 239);
  border: 2px solid rgb(58 130 255);
  border-radius: 8px;
  padding: 8px;
  color: #23232d;
  font-weight: 600;
  text-transform: uppercase;
  cursor: pointer;
}

#login-form button:hover{
  box-shadow: 0px .5px 5px #1145c7;
}

#login-form .footer {
  display: flex;
  justify-content: space-between;
}

#login-form .footer label{
  margin-top: 20px;
  font-size: 12px;
  color:#b0aeb6;
  cursor: pointer;
}

#rules {
  display: flex;
  justify-content: center;
  margin: 10px 70px 20px auto;
}

#rules label{
  font-size: 16px;
  margin-left: 8px;
  color: #b0aeb6;

}

#rules input{
  height: 20px;
  width: 20px;
  border: 1px solid #34495E;
  border-radius: 4px;
  outline: none;
  transition-duration: 0.3s;
  background-color: transparent;
  cursor: pointer;
}

</style>