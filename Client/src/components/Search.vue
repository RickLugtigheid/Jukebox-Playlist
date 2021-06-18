<template>
  <div class="container">
      <h2>Genres</h2>
      <div class="row">
        <div class="col-lg-2 col-sm-3 card m-2" v-for="genre in genres.data" :key="genre.id" :style="{ 'background-color':hexAddShade(hexAddAlpha(stringToColor(genre.attributes.name), .25), .25) }">
          <router-link :to="{path: '/search?type=genre&query=' + genre.id}" data-scroll>
            <div class="card-body text-white">
              <h5 class="card-title">{{ genre.attributes.name }}</h5>
            </div>
          </router-link>
        </div>
      </div>
  </div>
</template>

<script>
import server from '../jukebox-api';
import util   from '../util';
export default {
  data () 
  {
    return {
      genres: null
    }
  },
  mounted()
  {
    server.getGenres(this.$cookies.get('token')).then(res => {
      this.genres = res.data;
    }).catch(util.handleApiError);
  },
  methods: {
    stringToColor: util.stringToColor,
    hexAddAlpha: util.hexAddAlpha,
    hexAddShade: util.hexAddShade
  }
}
</script>
<style>
a {
  text-decoration: none;
}
</style>