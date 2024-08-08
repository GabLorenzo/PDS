<template>
    <div id="app">
      <div class="nav">
        <img alt="mmsu" src="/resources/pic/1Seal.png">
        <h1 class="title">Mariano Marcos State University</h1>
        <button v-if="!isLoginRoute" @click="logout" class="logout-btn">Logout</button>
      </div>

      <div v-if="!isLoginRoute" class="pindot">
        <router-link to="/basic" exact-active-class="active-link">
          <img alt="Basic" src="/public/images/basic.png" class="nav-icon"> Basic
        </router-link> &nbsp;

        <router-link to="/address" exact-active-class="active-link">
          <img alt="Address" src="/public/images/gps.png" class="nav-icon"> Address
        </router-link> &nbsp;

        <router-link to="/family" exact-active-class="active-link">
          <img alt="Family" src="/public/images/parental-control.png" class="nav-icon"> Family
        </router-link> &nbsp;

        <router-link to="/education" exact-active-class="active-link">
          <img alt="Education" src="/public/images/mortarboard.png" class="nav-icon"> Education
        </router-link> &nbsp;

        <router-link to="/work" exact-active-class="active-link">
          <img alt="Work" src="/public/images/suitcase.png" class="nav-icon"> Work
        </router-link> &nbsp;

        <router-link to="/achievement" exact-active-class="active-link">
          <img alt="Achievement" src="/public/images/medal-.png" class="nav-icon"> Achievement
        </router-link> &nbsp;

        <router-link to="/print" exact-active-class="active-link">
          <img alt="Overall" src="/public/images/file.png" class="nav-icon"> Overall
        </router-link>
      </div>

      <router-view/>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'app',
    computed: {
        isLoginRoute() {
            return this.$route.path === '/login'; // Adjust the path if your login route is different
        }
    },
    methods: {
        async logout() {
            try {
                // Handle logout process here, clear client-side state
                window.authenticated = false;
                this.$router.push('/login');
            } catch (error) {
                console.error('Logout failed');
            }
        }
    }
};
</script>

<style scoped>
body {
    margin: 0;
    padding: 0;
    font-family: Times New Roman, serif;
}


.nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background-color: #0c4b05;
    border: 5px solid #feda3b;
    border-left: #0c4b05;
    border-right: #0c4b05;
    padding: 10px;
    box-sizing: border-box;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 20px;
    transition: all 0.3s ease;
}

.nav img {
    height: 70px;
    width: auto;
}

.title {
    color: white;
    margin-left: -20px;
    font-size: 50px;
    flex-grow: 1;
}

.logout-btn {
    background-color: #0c4b05; /* Button background color */
    color: #fff; /* Button text color */
    border: none;
    border-radius: 5px;
    padding: 8px 16px;
    width: 100px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

.logout-btn:hover {
    background-color: #093a04; /* Darker shade on hover */
}

/* Responsive Styles for Navigation */
@media (max-width: 768px) {
    .title {
        display: none; /* Hide the title on smaller screens if needed */
    }
}

@media (max-width: 480px) {
    .nav {
        padding: 5px;
    }

    .nav img {
        height: 50px; /* Adjust the height for smaller screens */
    }
}

/* Pindot Styles */
.pindot {
    position: fixed;
    top: 60px;
    left: 0;
    bottom: 0;
    width: 200px;
    padding: 10px;
    background-color: #0c4b05;
    box-shadow: 50px rgba(2, 2, 2, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: center;
    font-family: Arial, sans-serif;
    font-size: 20px;
    overflow-y: auto;
    transition: all 0.3s ease; /* Smooth transition for responsiveness */
}

.pindot a {
    display: flex;
    align-items: center; /* Align items vertically in the center */
    text-decoration: none;
    color: white;
    padding: 5px 0;
    margin-left: 10px; /* Space between the left edge and the content */
}

.pindot .nav-icon {
    width: 24px; /* Set a uniform width for the icons */
    height: auto; /* Maintain aspect ratio */
    margin-right: 10px; /* Space between the icon and the text */
}

.pindot a:hover {
    color: white;
}

/* Highlight Active Links */
.pindot .router-link-active {
    border-radius: 5px; /* Optional: Rounded corners for the border */
    background-color: rgba(0, 53, 2, 0.461); /* Background color with transparency */
    padding: 8px; /* Adjust padding to make sure the background color covers the border */
    margin-left: 30px; /* Ensure alignment matches other links */
    box-sizing: border-box; /* Ensure padding and border are included in width */
    font-weight: bold;
}

/* Responsive Styles for Pindot */
@media (max-width: 768px) {
    .pindot {
        width: 150px; /* Reduce width for medium screens */
        font-size: 1.2em;
        padding: 8px;
    }

    .pindot a {
        font-size: 18px;
        margin-left: 0; /* Remove margin for better alignment */
    }
}

@media (max-width: 480px) {
    .pindot {
        width: 100px; /* Reduce width for smaller screens */
        font-size: 1em;
        padding: 5px;
        bottom: 0; /* Ensure it remains at the bottom */
    }

    .pindot a {
        font-size: 14px;
    }
}

/* Footer Styles */
.footer {
    background-color: #4a4444;
    color: #fff;
    padding: 10px;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
}
</style>
