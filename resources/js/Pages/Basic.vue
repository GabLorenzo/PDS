<template>
    <div class="main-container">
      <div class="basic-form">
        <h2>Personal Data Sheet</h2>
        <form @submit.prevent="submitForm">
          <!-- Form Fields -->
          <div class="form-row">
            <div class="form-group">
              <label for="surname">Surname:</label>
              <input type="text" id="surname" v-model="formData.surname" required>
            </div>
            <div class="form-group">
              <label for="firstname">Firstname:</label>
              <input type="text" id="firstname" v-model="formData.firstname" required>
            </div>
            <div class="form-group">
              <label for="middlename">Middlename:</label>
              <input type="text" id="middlename" v-model="formData.middlename">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="extname">Ext. Name:</label>
              <input type="text" id="extname" v-model="formData.extname">
            </div>
            <div class="form-group">
              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" v-model="formData.dob" required>
            </div>
            <div class="form-group">
              <label for="placeOfBirth">Place of Birth:</label>
              <input type="text" id="placeOfBirth" v-model="formData.place_of_birth" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="sex">Sex:</label>
              <div class="radio-group">
                <label>
                  <input type="radio" v-model="formData.sex" value="Male" required> Male
                </label>
                <label>
                  <input type="radio" v-model="formData.sex" value="Female" required> Female
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>Citizenship:</label>
              <div class="radio-group">
                <label>
                  <input type="radio" v-model="formData.citizenship" value="Filipino" required> Filipino
                </label>
                <label>
                  <input type="radio" v-model="formData.citizenship" value="Dual" required> Dual Citizenship
                </label>
              </div>
            </div>
          </div>

          <!-- Dual Citizenship Options -->
          <div v-if="formData.citizenship === 'Dual'" class="dual-citizenship">
            <div class="form-row">
              <div class="form-group">
                <label for="dualType">Type of Dual Citizenship:</label>
                <select id="dualType" v-model="formData.dualType">
                  <option value="">--Select Type--</option>
                  <option value="By Birth">By Birth</option>
                  <option value="By Naturalization">By Naturalization</option>
                </select>
              </div>
              <div class="form-group">
                <label for="dualCountry">Country:</label>
                <input type="text" id="dualCountry" v-model="formData.dualCountry">
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="height">Height (m):</label>
              <input type="number" step="0.01" id="height" v-model="formData.height" required>
            </div>
            <div class="form-group">
              <label for="weight">Weight (kg):</label>
              <input type="number" step="0.1" id="weight" v-model="formData.weight" required>
            </div>
            <div class="form-group">
              <label for="bloodType">Blood Type:</label>
              <input type="text" id="bloodType" v-model="formData.bloodType">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="civilStatus">Civil Status:</label>
              <select id="civilStatus" v-model="formData.civil_status" required>
                <option value="">--Select Status--</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
                <option value="Divorced">Divorced</option>
              </select>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" v-model="formData.email" required>
            </div>
          </div>

          <div class="form-buttons">
            <div class="warning-container">
              <div v-if="warningMessage" class="warning-message">{{ warningMessage }}</div>
            </div>
            <!-- Remove the Next Button -->
            <button type="button" class="save-button" @click="saveForm">Save</button>
          </div>
        </form>
      </div>

      <div class="upload-container">
        <label for="photo">
          <img :src="photoDataUrl || '/images/Pro.png'" alt="Profile Picture" class="profile-img">
          <pre>Upload Profile</pre>
        </label>
        <input type="file" id="photo" @change="handleFileUpload" accept="image/*">
      </div>
    </div>
  </template>

  <script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        user_id: '',
        surname: '',
        firstname: '',
        middlename: '',
        extname: '',
        dob: '',
        place_of_birth: '',
        sex: '',
        citizenship: '',
        dualType: '',
        dualCountry: '',
        height: '',
        weight: '',
        bloodType: '',
        civil_status: '',
        email: ''
      },
      warningMessage: '',
      photoDataUrl: ''
    };
  },
  methods: {
    resetForm() {
      this.formData = {
        user_id: '',
        surname: '',
        firstname: '',
        middlename: '',
        extname: '',
        dob: '',
        place_of_birth: '',
        sex: '',
        citizenship: '',
        dualType: '',
        dualCountry: '',
        height: '',
        weight: '',
        bloodType: '',
        civil_status: '',
        email: ''
      };
      this.photoDataUrl = '';
      this.warningMessage = '';
    },

    async fetchUserData() {
      const userId = localStorage.getItem('user_id');
      if (userId) {
        try {
          const response = await axios.get(`/personal-info/${userId}`);
          if (response.data && typeof response.data === 'object') {
            this.formData = response.data;
            this.photoDataUrl = response.data.photoDataUrl || '';
          } else {
            console.error('Unexpected data format:', response.data);
            this.warningMessage = 'Failed to fetch user data.';
          }
        } catch (error) {
          console.error('Error fetching user data:', error.response ? error.response.data : error.message);
          this.warningMessage = 'Error fetching user data.';
        }
      } else {
        // Load data from localStorage if available
        const savedData = localStorage.getItem(`formData_${userId}`);
        if (savedData) {
          this.formData = JSON.parse(savedData);
        }
      }
    },

    async submitForm() {
      try {
        if (!this.isFormValid()) {
          this.warningMessage = 'Please complete all required fields.';
          return;
        }

        const response = await axios.post('/personal-info', this.formData);
        console.log('Data saved successfully:', response.data);
      } catch (error) {
        console.error('Error saving form data:', error.response ? error.response.data : error.message);
        this.warningMessage = 'Error saving form data.';
      }
    },

    isFormValid() {
      const requiredFields = ['surname', 'firstname', 'dob', 'place_of_birth', 'sex', 'citizenship', 'civil_status', 'email', 'height', 'weight'];
      const isValid = requiredFields.every(field => this.formData[field] && this.formData[field].toString().trim() !== '');
      const isDual = this.formData.citizenship === 'Dual';
      const isDualValid = !isDual || (this.formData.dualType && this.formData.dualCountry);

      return isValid && isDualValid;
    },

    goTo(route) {
      if (this.isFormValid() || route === '/basic') {
        this.warningMessage = '';
        this.$router.push(route);
      } else {
        this.warningMessage = 'Please complete the form before proceeding.';
      }
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.photoDataUrl = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    saveForm() {
      axios.post('/personal-info', this.formData)
        .then(response => {
          this.warningMessage = 'Form data saved successfully!';
          alert('Addresses saved successfully');
          this.goTo('/address');
        })
        .catch(error => {
          console.error('Error saving form data:', error);
          alert('Addresses saved unsuccessfully');
          this.warningMessage = 'Error saving form data.';
        });
    },

    saveFormToLocalStorage() {
      const userId = localStorage.getItem('user_id');
      if (userId) {
        localStorage.setItem(`formData_${userId}`, JSON.stringify(this.formData));
      }
    },

    clearFormData() {
      const userId = localStorage.getItem('user_id');
      if (userId) {
        localStorage.removeItem(`formData_${userId}`);
      }
    }
  },
  mounted() {
    this.fetchUserData();
  },
  watch: {
    formData: {
      handler() {
        this.saveFormToLocalStorage();
      },
      deep: true
    }
  },
  beforeDestroy() {
    this.clearFormData();
  }
};
</script>

  <style scoped>
.main-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 15px;
  padding: 50px;
  margin-top: 25px;
}

.basic-form {
  margin-left: 200px;
  margin-top: 30px;
  width: 100%;
  max-width: 70%;
  padding: 20px;
  background-color: rgba(240, 240, 240, 0.8);
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
  text-align: left;
}

.form-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: -5px;
}

.form-group {
  flex: 1;
  margin-right: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="email"],
input[type="tel"],
input[type="number"],
select {
  width: 90%;
  padding: 10px;
  font-size: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
  margin-bottom: 10px;
}

.radio-group {
  display: flex;
  gap: 10px;
}

.warning-message {
  color: red;
  font-weight: bold;
}

.warning-container {
  display: flex;
  justify-content: flex-start;
  flex: 1;
}

.form-buttons {
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
}

.save-button {
  width: 100px;
  padding: 10px 20px;
  background-color: #187b0d;
  color: #fff;
  border: none;
  cursor: pointer;
  margin-top: 20px; /* Add space above the button */
  align-self: flex-end; /* Align the button to the end of the form-buttons div */
}

.save-button:hover {
  background-color: #145a09;
}

.upload-container {
  width: 200px;
  padding: 10px;
  background-color: #e0e0e0;
  border: 1px solid #ccc;
  border-radius: 8px;
  text-align: center;
  margin-top: 30px;
}

.profile-img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 20%;
  cursor: pointer;
}

input[type="file"] {
  display: none;
}

.dual-citizenship {
  margin-top: 15px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

@media (max-width: 600px) {
  .main-container {
    flex-direction: column;
    align-items: center;
  }

  .basic-form {
    max-width: 100%;
    margin-bottom: 20px;
  }

  .upload-container {
    width: 100%;
  }
}
</style>
