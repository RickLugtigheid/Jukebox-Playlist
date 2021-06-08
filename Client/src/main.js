// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

// [Set router events]
router.beforeEach((to, from, next) => {
  // Check if we don't have a token in our cookies we should reroute to the login page
  if (to.name !== 'Login' && !Vue.$cookies.isKey('token')) next({ name: 'Login' })
  else next()
})

Vue.config.productionTip = false

Vue.use(require('vue-cookies'))

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
