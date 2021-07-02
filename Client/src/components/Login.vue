<template>
  <div id="app">
    <!-- v-if so we don't get an error on first render -->
    <form v-if="users">
      <button v-on:click="register()" >Register</button>
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
import swa    from 'sweetalert2'
import Swal from 'sweetalert2';
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
    }).catch(err => 
    {
      const author = require('../../package.json').author;
      swa.fire({
        title: err.response.status + 'couldn\'t load site',
        icon: 'error',
        html: `Please contact the site manager - <a href='mailto:${author.email}?subject=${err.response.status} error&body=${JSON.stringify(err.response, null, 2)}'>${author.email}</a>`,
        showConfirmButton: false,
        allowOutsideClick: false
      });
      console.error(err)
    });
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
        swa.fire('Incorrect password given', '', 'warning');
      });
    },
    register()
    {
      Swal.fire({
        title: 'Register',
        html: `<input type="text" id="name" class="swal2-input" placeholder="Username">
        <input type="password" id="password" class="swal2-input" placeholder="Password">`,
        confirmButtonText: 'Sign in',
        focusConfirm: false,
        preConfirm: () => {
          const name = Swal.getPopup().querySelector('#name').value
          const password = Swal.getPopup().querySelector('#password').value
          if (!name || !password) {
            Swal.showValidationMessage(`Please enter name and password`)
          }
          return { name: name, password: password }
        }
      }).then((res) => {
        server.createUser(res.value.name, res.value.password)
        .then(() => Swal.fire('User Created', '', 'success'))
        .catch(err => Swal.fire(err.response.status + ' Could not create user', '', 'error'));
      })
    }
  }
}
</script>

<style>

</style>
