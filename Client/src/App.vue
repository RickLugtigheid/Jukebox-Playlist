<template>
    <div id="app" class="container">
      <div class="row">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <nav id="spy">
                <ul class="sidebar-nav nav">
                    <li class="sidebar-brand">
                        <router-link to="/" data-scroll><span class="fa fa-home solo">Home</span></router-link>
                    </li>
                    <li>
                      <router-link to="/search" data-scroll>
                            <span class="fa fa-search solo">Search</span>
                      </router-link>
                    </li>
                    <li>
                        <router-link to="/library" data-scroll>
                            <span class="fa fa-anchor solo">Your Library</span>
                        </router-link>
                    </li>
                    <li>
                        <a href="#anch3" data-scroll>
                            <span class="fa fa-anchor solo">Anchor 3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#anch4" data-scroll>
                            <span class="fa fa-anchor solo">Anchor 4</span>
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
export default {
  name: 'App',
  mounted()
  { 
    // Bootstrap js
    AppendHead('script',
    {
      src: 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js',
      integrity: 'sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4',
      crossorigin: 'anonymous'
    });
    // Fontawesome js
    AppendHead('script', 
    {
      src: 'https://kit.fontawesome.com/5eb0758b3a.js',
      crossorigin: 'anonymous'
    });
  }
}
/**
 * @param {'script'|'link'} element
 * @param {{}} attributes
 */
function AppendHead(element, attributes)
{
  let item = document.createElement(element);
  Object.keys(attributes).forEach(key => {
    item.setAttribute(key, attributes[key]);
  });
  document.head.appendChild(item);
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
  color: #41484c;
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
  color: #999999;
}

.sidebar-nav > .sidebar-brand a:hover {
  color: #fff;
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
