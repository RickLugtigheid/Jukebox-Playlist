<template>
    <div class="container-fluid spotify-app" id="app">
      <div class="row">
        <section class="col-xs-1 side-nav clean-paddings">
          <nav class="navbar">
            <ul class="nav">
              <li class="brand-icon"><a href="#"><span class="fa fa-spotify"></span></a></li>
              <li><a href="#"><span class="fa fa-search"></span>Search</a></li>
              <li><a href="#"><span class="fa fa-headphones"></span>Browse</a></li>
              <li><a href="#"><span class="fa fa-feed"></span>Radio</a></li>
              <li class="active"><a href="#"><span class="fa fa-bars fa-rotate-90"></span>Your Music</a></li>
              <li><a href="#"><span class="fa fa-users"></span>Follow</a></li>
            </ul>
          </nav>
        </section>
        <section class="col-xs-11 clean-paddings">
          <nav>
            <div class="top-nav container-fluid">
              <ul class="nav navbar-nav">
                <li><a href="#">Playlists</a></li>
                <li class="active"><a href="#">Songs</a></li>
                <li><a href="#">Albums</a></li> 
                <li><a href="#">Artists</a></li> 
              </ul>
            </div>
          </nav>
          <table class="table table-songs">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Song</th>
                <th>Artist</th>
                <th>Album</th>
                <th><span class="fa fa-calendar-o"></span></th>
                <th><span class="fa fa-clock-o"></span></th>
              </tr>
            </thead>
            <tbody>
              <tr tabindex="1">
                <td>
                  <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
                    <span class="fa fa-play fa-stack-1x"></span>
                    <span class="fa fa-circle-thin fa-stack-2x"></span>
                  </a>
                </td>
                <td><span class="fa fa-check"></span></td>
                <td>Memory</td>
                <td>Sugarcult</td>
                <td>Palm Trees and Power Lines</td>
                <td class="secondary-info">2016-07-23</td>
                <td class="secondary-info">3:54</td>
              </tr>
              <tr tabindex="1">
                <td>
                  <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
                    <span class="fa fa-play fa-stack-1x"></span>
                    <span class="fa fa-circle-thin fa-stack-2x"></span>
                  </a>
                </td>
                <td><span class="fa fa-check"></span></td>
                <td>Memory</td>
                <td>Sugarcult</td>
                <td>Palm Trees and Power Lines</td>
                <td class="secondary-info">2016-07-23</td>
                <td class="secondary-info">3:54</td>
              </tr>
              <tr tabindex="1" class="active">
                <td>
                  <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
                    <span class="fa fa-play fa-stack-1x"></span>
                    <span class="fa fa-circle-thin fa-stack-2x"></span>
                  </a>
                </td>
                <td><span class="fa fa-check"></span></td>
                <td>Memory</td>
                <td>Sugarcult</td>
                <td>Palm Trees and Power Lines</td>
                <td class="secondary-info">2016-07-23</td>
                <td class="secondary-info">3:54</td>
              </tr>
              <tr tabindex="1">
                <td>
                  <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
                    <span class="fa fa-play fa-stack-1x"></span>
                    <span class="fa fa-circle-thin fa-stack-2x"></span>
                  </a>
                </td>
                <td><span class="fa fa-check"></span></td>
                <td>Memory</td>
                <td>Sugarcult</td>
                <td>Palm Trees and Power Lines</td>
                <td class="secondary-info">2016-07-23</td>
                <td class="secondary-info">3:54</td>
              </tr>
            </tbody>
          </table>
        </section>
      </div>
      <router-view/>
    </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
body {
  background-color: black;
  color: #dadce1;
  min-width: 960px;
}
.nav li a,
.nav li a:focus,
.nav li a:hover,
.nav li a:active {
  background: transparent;
  color: inherit;
}
.fa {
  text-align: center;
}




.side-nav {
  background: #1c1c1f;
  color: #88898c;
  text-align: center;
}
.side-nav .navbar {
  margin-bottom: 0;
}
.side-nav li {
  font-size: 12px;
}
.side-nav li a {
  border-left: 3px solid transparent;
  padding-bottom: 15px;
}
.side-nav li.active a,
.side-nav li a:focus,
.side-nav li a:active,
.side-nav li a:hover {
  color: #dadce1;
  border-color: #84bd00;
  outline: none;
}
.side-nav .fa {
  font-size: 30px;
  margin-bottom: 10px;
  display: block;
}
.side-nav .brand-icon .fa {
  font-size: 50px;
  color: #dadce1;
}



.top-nav {
  text-transform: uppercase;
  font-size: 12px;
  font-weight: bold;
  color: #;
}

.top-nav li a {
  border-bottom: 2px solid transparent;
}

.top-nav li.active a,
.top-nav li a:focus,
.top-nav li a:active,
.top-nav li a:hover {
  border-bottom-color: #84bd00;
  color: #dadce1;
  outline: transparent;
}

.clean-paddings {
  padding: 0;
}

.table-songs,
.table-songs thead th,
.table-songs thead tr th,
.table-songs tbody tr,
.table-songs tbody tr td {
  color: #dadce1;
  border-color: #1c1c1f;
  font-size: 12px;
}

.table-songs tbody tr:focus,
.table-songs tbody tr:hover,
.table-songs tbody tr.active td {
  background-color: #1c1c1f;
}

.table-songs thead tr th {
  text-transform: uppercase;
  color: #7d7e81;
  font-weight: normal;
}

.table-songs tbody {
  overflow: scroll;
  height: 200px;
}
.table-songs .play-btn {
  color: transparent;
  font-size: 12px;
}
.table-songs .secondary-info {
  color: #7d7e81;
}

.table-songs tr.active .play-btn,
.table-songs .play-btn:focus,
.table-songs .play-btn:hover {
  color: #dadce1;
  outline: none;
}
</style>
