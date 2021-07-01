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
            <td class="secondary-info">{{ parseDuration(song.attributes.duration) }}</td>
            <td>
              <div class="dropdown show">
                <a  href="#" tabindex="0" class="text-light fa-stack fa-lg" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-ellipsis-v"></span>
                </a>
                <!-- Dropdown actions -->
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <button class="dropdown-item" :id="song.id">Add to playlist</button>
                  <button class="dropdown-item" :id="song.id" v-on:click="remove">Remove</button>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import { SessionPlaylist, ApiPlaylist }   from '../util';
export default {
  data () 
  {
    return {
      /**
       * @type {SessionPlaylist}
       */
      list: null,
      isSession: false,
      songs: null
    }
  },
  mounted ()
  {
    /**
     * If our playlist is a session playlist
     * @var {boolen}
     */
    let isSession = (this.$route.params.session == '1');
    if (isSession)
      this.list = SessionPlaylist.getSession(this.$route.params.id);
    else
      this.list = new ApiPlaylist(this.$cookies.get('token'), this.$route.params.id)
    this.list.getSongs().then(res => this.songs = res.data);
  },
  methods: {
    parseDuration(durationSeconds) {
        return Math.floor(durationSeconds / 60) + ":" + (durationSeconds % 60 ? durationSeconds % 60 : '00')
    },
    remove(event)
    {
      this.list.removeSong(event.target.id);
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