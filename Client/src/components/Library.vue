<template>
  <div class="container">
      {{ playlists }}
  </div>
</template>

<script>
import server from '../jukebox-api';
import util   from '../util';
export default {
  data () 
  {
    return {
        playlists: null
    }
  },
  mounted()
  {
    server.getPlaylists(this.$cookies.get('token')).then(res => {
      this.playlists = res.data;
    }).catch(util.handleApiError);
  }
}
</script>