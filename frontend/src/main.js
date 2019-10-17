import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import ApiService from "./common/api.service";
import store from "./store";

Vue.config.productionTip = false

ApiService.init();

new Vue({
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
