/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap")

import Vue from "vue"
import vuetify from "./vuetify"
import router from "./router"
import store from "./store"

window.Vue = require("vue")

import App from "./components/AppComponent"

const app = new Vue({
  store,
  router,
  vuetify,
  components: {
    App: App,
  },
}).$mount("#app")
