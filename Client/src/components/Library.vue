<template>
  <div class="container">
    <!-- v-if so we don't get an error on first render -->
    <div class="row" v-if="playlists">
      <div class="col-lg-3 col-sm-4 card m-3" v-for="list in playlists.data" :key="list.id" :style="{ 'background-color':hexAddShade(hexAddAlpha(stringToColor(list.attributes.name), .25), .25) }">
        <router-link :to="{path: '/playlist/' + list.id + '/0'}" data-scroll>
        <h2>{{ list.attributes.name }}</h2>
        </router-link>
      </div>
      <div class="col-lg-3 col-sm-4 card m-3" v-for="list in sessions" :key="list" :style="{ 'background-color':hexAddShade(hexAddAlpha(stringToColor(list.name), .25), .25) }">
        <router-link :to="{path: '/playlist/' + list.id + '/1'}" data-scroll>
        <h2>{{ list.name }}</h2>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import server from '../jukebox-api';
import util   from '../util';
import {SessionPlaylist} from '../util'
export default {
  data () 
  {
    return {
      playlists: null,
      sessions: SessionPlaylist.sessions
    }
  },
  mounted()
  {
    server.getPlaylists(this.$cookies.get('token')).then(res => {
      this.playlists = res.data;
    }).catch(util.handleApiError);
  },
  methods: {
    stringToColor: util.stringToColor,
    hexAddAlpha: util.hexAddAlpha,
    hexAddShade: util.hexAddShade
  }
}
</script>