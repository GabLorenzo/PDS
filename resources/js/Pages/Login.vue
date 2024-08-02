<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" v-model="username" id="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" v-model="password" id="password" required />
      </div>
      <button type="submit">Login</button>
      <p v-if="error" class="error-message">{{ error }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          username: this.username,
          password: this.password
        });
        console.log(response.data)
        // Handle successful login, e.g., store token and redirect
        if(response.data===1) {
        //  window.location.reload();
          this.$router.push("/basic");
        }else {
          alert("incorrect username or password")
        }
        // Example: Redirect to dashboard
          
      } catch (err) {
        this.error = 'Invalid username or password.';
        console.error(err);
      }
    },
    // checkUser() {
    //           axios.post("/Check").then(({ data }) => {
    //               if (!data) {
    //                   // window.location.reload()
    //                   this.$router.push("/login");
    //               }
    //           });
    //       },
  },
  // mounted() {
  //   this.checkUser();
  // }
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-top: 250px;
}

.form-group {
  margin-bottom: 15px;
}

.error-message {
  color: red;
}
</style>
