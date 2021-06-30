<template>
    <div id="app" class="container">
      <div class="row">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <nav id="spy">
                <ul class="sidebar-nav nav">
                    <li class="sidebar-brand">
                        <router-link to="/" data-scroll><span class="fas fa-home solo">Home</span></router-link>
                    </li>
                    <li>
                      <router-link to="/search" data-scroll>
                        <span class="fas fa-search">Search</span>
                      </router-link>
                    </li>
                    <li>
                        <router-link to="/library" data-scroll>
                            <span class="far fa-list-alt">Your Library</span>
                        </router-link>
                    </li>
                    <hr>
                    <li>
                        <a href="#" v-on:click="createPlaylist()" data-scroll>
                          <span class="far fa-plus-square">Create Playlist</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-2"></div>
        <div class="col-10">
          <router-view/>
        </div>
      </div>
    </div>
</template>

<script>
// Import bootstrap
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import swal   from 'sweetalert2'
import server from './jukebox-api'
import {SessionPlaylist} from './util'
export default {
  name: 'App',
  methods:
  {
    createPlaylist()
    {
      swal.fire({
        title: 'Create Playlist',
        html: `
        <label for="swal-input-name">Playlist name</label>
        <input type="text" id="swal-input-name" class="swal2-input" placeholder="Name">
        <label for="swal-input-temp">Temp list</label>
        <input type="checkbox" id="swal-input-temp" class="swal2-input">`,
        focusConfirm: false,
        preConfirm: () => {
          return {
            name: document.getElementById('swal-input-name').value,
            temp: document.getElementById('swal-input-temp').value == 'on'
          }
        },
        confirmButtonText: 'Create',
        showCancelButton: true
      }).then(res =>
      {
        if (res.isDismissed) return;
        // Create a temporary list (so a session)
        if (res.value.temp)
          new SessionPlaylist(res.value.name);
        // Create a new playlist with the api
        else
          server.createPlaylist(this.$cookies.get('token'));            
      });
    }
  }
}
</script>

<style>
body {
  background-color: black;
  color: #dadce1;
}

#wrapper {
  padding-left: 250px;
  transition: all 0.4s ease 0s;
}

#sidebar-wrapper {
  margin-left: -250px;
  left: 250px;
  width: 250px;
  background: #1c1c1f;
  color: #88898c;
  position: fixed;
  height: 100%;
  overflow-y: auto;
  z-index: 1000;
  transition: all 0.4s ease 0s;
}

#wrapper.active {
  padding-left: 0;
}

#wrapper.active #sidebar-wrapper {
  left: 0;
}

#page-content-wrapper {
  width: 100%;
}

.sidebar-nav {
  position: absolute;
  top: 0;
  width: 250px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.sidebar-nav li {
  line-height: 40px;
  text-indent: 20px;
}

.sidebar-nav li a {
  color: #999999;
  display: block;
  text-decoration: none;
  padding-left: 60px;
}

.sidebar-nav li a span:before {
  position: absolute;
  left: 0;
  text-align: center;
  width: 20px;
  line-height: 18px;
}

.sidebar-nav li a:hover,
.sidebar-nav li.active {
  color: #fff;
  background: rgba(255,255,255,0.2);
  text-decoration: none;
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
  text-decoration: none;
}

.sidebar-nav > .sidebar-brand {
  height: 65px;
  line-height: 60px;
  font-size: 18px;
}

.sidebar-nav > .sidebar-brand a {
  color: #fcfcfc;
}

.sidebar-nav > .sidebar-brand a:hover {
  color: rgb(255, 255, 255);
  background: none;
}



.content-header {
  height: 65px;
  line-height: 65px;
}

.content-header h1 {
  margin: 0;
  margin-left: 20px;
  line-height: 65px;
  display: inline-block;
}

#menu-toggle {
    text-decoration: none;
}

.btn-menu {
  color: #000;
} 

.inset {
  padding: 20px;
}

#spy li
{
  width: 100%;
}

/* @media (max-width:767px) {

  #wrapper {
    padding-left: 0;
  }

  #sidebar-wrapper {
    left: 0;
  }

  #wrapper.active {
    position: relative;
    left: 250px;
  }

  #wrapper.active #sidebar-wrapper {
    left: 250px;
    width: 250px;
    transition: all 0.4s ease 0s;
  }

  #menu-toggle {
    display: inline-block;
  }

  .inset {
    padding: 15px;
  }

} */
</style>
