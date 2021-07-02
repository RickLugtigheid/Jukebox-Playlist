<template>
  <div class="container">
    <!-- v-if so we don't get an error on first render -->
    <div class="row" v-if="playlists">
      <div class="col-lg-3 col-sm-4 card m-3" v-for="list in playlists" :key="list.id" :style="{'background-color':hexAddShade(hexAddAlpha(stringToColor(list.name), .25), .25) }">
        <h2>{{ list.name }}</h2>
        <b>- {{ getDuration(list) }} -
          <router-link class="playlist-text" :to="{path: '/playlist/' + list.id + '/' + isSession(list)}" data-scroll>
            <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
              <span class="fa fa-play fa-stack-1x"></span>
              <span class="fa fa-circle-thin fa-stack-2x"></span>
            </a>
          </router-link>
        </b>
      </div>
    </div>
  </div>
</template>

<script>
import server from '../jukebox-api';
import util, { ApiPlaylist }   from '../util';
import {SessionPlaylist} from '../util'
export default {
  data () 
  {
    return {
      /**
       * @type {Array.<IPlaylist>}
       */
      playlists: [],
      /**
       * @type {Array.<string, int>}
       */
      durations: []
    }
  },
  mounted()
  {
    server.getPlaylists(this.$cookies.get('token')).then(res => {
      res.data.data.forEach(res => {
        let list = new ApiPlaylist(this.$cookies.get('token'), res.id, res.attributes.name)
        // Set list duration
        list.getTotalDuration().then(duration => 
        {
          this.durations[list.id] = duration;
          this.playlists.push(list); // Add here so vue will render when we have the list and the duration
        });
      });
      SessionPlaylist.sessions.forEach(session =>
      {
        // Set list duration
        session.getTotalDuration().then(duration => 
        {
          this.durations['session-' + session.id] = duration;
          this.playlists.push(session); // Add here so vue will render when we have the list and the duration
        });
      });
    }).catch(util.handleApiError);
  },
  methods: {
    stringToColor: util.stringToColor,
    hexAddAlpha: util.hexAddAlpha,
    hexAddShade: util.hexAddShade,
    isSession(list)
    {
      // I use this as a method because vue doesn't allow be to put it in {{ }}
      return list instanceof SessionPlaylist ? '1' : '0';
    },
    getDuration(list)
    {
      let key      = list instanceof SessionPlaylist ? 'session-' + list.id : list.id;
      let duration = this.durations[key];
      let hours    = Math.floor(duration / (60 * 60));
      let minutes  = Math.floor(duration / 60);
      return `${hours} hr ${minutes} min`;
    }
  }
}
</script>
<style>
  .playlist-text
  {
    color: white;
  }
</style>