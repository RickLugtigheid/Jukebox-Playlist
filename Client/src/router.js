import Vue from 'vue'
import Router from 'vue-router'

// [Import Components]
import Home from '@/components/Home'
import Login from '@/components/Login'
import Search from '@/components/Search'
import Library from '@/components/Library'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/search',
      name: 'Search',
      component: Search
    },
    {
      path: '/library',
      name: 'Library',
      component: Library
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
  ]
})
