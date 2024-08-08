<template>
    <div class="login-container">
      <div class="login-form">
        <h2>Login</h2>
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="username">Username:</label>
            <input v-model="username" id="username" type="text" required />
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input v-model="password" id="password" type="password" required />
          </div>
          <button type="submit">Login</button>
          <div v-if="error" class="error">{{ error }}</div>
          <div v-if="success" class="success">{{ success }}</div>
        </form>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        username: '',
        password: '',
        error: null,
        success: null,
      };
    },
    methods: {
      async login() {
        try {
          const response = await axios.post('/login', {
            username: this.username,
            password: this.password
          });

          // On successful login
          window.authenticated = true;
          this.$router.push('/basic');
        } catch (error) {
          this.error = 'Invalid credentials';
        }
      }
    }
  };
  </script>

  <style>
  .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2); /* Subtle gradient background */

  }

  .login-form {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px; /* Responsive width */
  }

  .login-form h2 {
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
    font-family: 'Times New Roman', serif; /* Font style */
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
  }

  .form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    box-sizing: border-box;
  }

  button {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    border: none;
    color: white;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  button:hover {
    background-color: #0056b3;
    transform: scale(1.02);
  }

  .error {
    margin-top: 15px;
    color: #ff4d4d;
    text-align: center;
    font-size: 14px;
  }

  .success {
    margin-top: 15px;
    color: #4caf50;
    text-align: center;
    font-size: 14px;
  }
  </style>
