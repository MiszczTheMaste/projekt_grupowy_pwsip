import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

let app = createApp(App);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '@sweetalert2/themes/dark/dark.css';
import 'sweetalert2/dist/sweetalert2.min.js';


app.use(router);
app.use(VueSweetalert2);

app.config.globalProperties.$alert = require('./assets/alerts');
axios.defaults.headers.post['Content-Type'] ='application/x-www-form-urlencoded';

app.mount('#app')
