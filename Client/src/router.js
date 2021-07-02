import Vue from 'vue'
import Router from 'vue-router'

// [Import Components]
import Home from '@/components/Home'
import Login from '@/components/Login'
import Songs from '@/components/Songs'
import Search from '@/components/Search'
import Library from '@/components/Library'
import Playlist from '@/components/Playlist'

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
      path: '/songs/:genreID',
      component: Songs
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

    {
      path: '/playlist/:id/:session',
      component: Playlist
    }
  ]
})
