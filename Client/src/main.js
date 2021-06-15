// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
//import { library } from '@fortawesome/fontawesome-svg-core'
//import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/// STYLE:
// https://codepen.io/juanvegab/pen/kkwkZy

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// [Set router events]
router.beforeEach((to, from, next) => {
  // Check if we don't have a token in our cookies we should reroute to the login page
  if (to.name !== 'Login' && !Vue.$cookies.isKey('token')) next({ name: 'Login' })
  else next()
  Vue.$cookies.remove('token')
})
/// TODO:
/// Back to Vue v2 to stop the error (https://stackoverflow.com/questions/63768491/export-default-imported-as-vue-was-not-found-in-vue#answer-63769591)

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
// Use cookies to store our token
Vue.use(require('vue-cookies'))

// Add fontawesome
//library.add(faUserSecret)
Vue.component('font-awesome-icon', FontAwesomeIcon)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  render: h => h(App)
  // components: { App },
  // template: '<App/>'
})