import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios'
import moment from 'moment'
import Admin from "./Admin.vue";

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.min.css'

axios.defaults.baseURL = '/pm2/api'
axios.defaults.headers = {
  'Content-Type': 'application/json',
  Accept: 'application/json'
}

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(require('vue-moment'), {
  moment
})

window.pm2AdminApp = new Vue({
  el: '#pm2-admin-app',
  render: h => h(Admin)
})
