<template>
  <div class="container">
    <section class="col-xs-11 clean-paddings">
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
        <!-- v-if so we don't get an error on first render -->
        <tbody v-if="songs && songs.data">
          <!-- class="active" for active song -->
          <tr tabindex="1" v-for="song in songs.data" :key="song.id" :id="song.id">
            <td>
              <a href="#" tabindex="0" class="play-btn fa-stack fa-lg">
                <span class="fa fa-play fa-stack-1x"></span>
                <span class="fa fa-circle-thin fa-stack-2x"></span>
              </a>
            </td>
            <td><span class="fa fa-check"></span></td>
            <td>{{ song.attributes.name }}</td>
            <td>{{ song.attributes.artist }}</td>
            <td>No albums Yet!</td>
            <td class="secondary-info">2016-07-23</td>
            <td class="secondary-info">3:54</td>
            <td>
              <div class="dropdown show">
                <a  href="#" tabindex="0" class="text-light fa-stack fa-lg" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-ellipsis-v"></span>
                </a>
                <!-- Dropdown actions -->
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <button class="dropdown-item" :id="song.id" v-on:click="remove">Remove</button>
                </div>
              </div>
            </td>
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
</template>

<script>
import server from '../jukebox-api';
import util   from '../util';
import {SessionPlaylist} from '../util'
export default {
  data () 
  {
    return {
      list: null,
      isSession: false,
      songs: null
    }
  },
  mounted ()
  {
    console.warn(this.$route.params);
    this.isSession = (this.$route.params.session == '1');
    if (this.isSession)
    {
      console.log(this.$route.params.id, SessionPlaylist.sessions);
      this.list = SessionPlaylist.getSession(this.$route.params.id);
      console.log(this.list)
      this.songs = this.list.songs.data;
    }
    else
      server.getPlaylists(this.$cookies.get('token'), this.$route.params.id).then(res => {
          this.list = res.data.data[0];
          // Get the songs for this list
          server.getPlaylistSongs(this.$cookies.get('token'), this.$route.params.id).then(res =>
          {
            this.songs = res.data;
          });
      }).catch(util.handleApiError);
  },
  methods: {
    remove(event)
    {
      if (this.isSession) this.list.removeSong(this.list.id);
      else server.removePlaylistSong(this.$cookies.get('token'), this.list.id, event.target.id).catch(util.handleApiError);
      // Reload
      this.$router.go()
    }
  }
}
</script>
<style>
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