<template>
  <div id="app">
    <form>
      <div class="form-group">
        <label for="uids">Choose a user:</label>
        <select name="uid" class="form-select" id="uids" ref="user">
          <option v-for="user in users.data" :key="user.id" :value="user.id"> {{ user.attributes.name }}</option>
        </select>
      </div>
      <br>
      <div class="form-group">
        <label for="passwd">Enter your password:</label>
        <input name="passwd" id="passwd" class="form-control" type="password" ref="passwd">
      </div>
      <button id="form-submit-btn" type="submit" class="btn btn-primary" @click.prevent="formLogin()">Submit</button>
    </form>
  </div>
</template>

<script>
import server from '../jukebox-api';
export default {
  data()
  {
    return {
      users: null
    }
  },
  mounted() 
  {
    server.getUsers().then(res => {
      this.users = res.data;
    }).catch(err => console.error(err));
  },
  methods: 
  {
    formLogin()
    {
      const uid   = this.$refs.user.value;
      const pass  = this.$refs.passwd.value;
      server.authenticate(uid, pass).then(token => 
      {
        // Set the token cookie to our token for later use
        this.$cookies.set('token', token);
        // Reroute to the home page
        this.$router.push({ path: '/' });
      }).catch(err =>
      {
        console.error(err.response.data);
        this.$refs.passwd.value = '';
        alert('Incorrect password given');
      });
    }
  }
}
</script>

<style>

</style>
