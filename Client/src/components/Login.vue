<template>
  <div id="app">
    <form>
      <label for="uids">Choose a user:</label>
      <select name="uid" id="uids" ref="user">
        <option v-for="user in users.data" :key="user.id" :value="user.id"> {{ user.attributes.name }}</option>
      </select>
      <br>
      <label for="passwd">Enter your password:</label>
      <input name="passwd" id="passwd" type="password" ref="passwd">
      <button @click.prevent="formLogin()">Submit</button>
    </form>
      <br>
    {{ users.data }}
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
        console.log(token);
        this.$cookies.set('token', token);
        console.log(this.$cookies.get('token'));
        // Reroute to the home page
        this.$router.push({ path: '/' });
      });
    }
  }
}
</script>

<style>

</style>
