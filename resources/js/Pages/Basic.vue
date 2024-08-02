<template>
  <div class="main-container">
    <div class="basic-form">
      <h2>Personal Data Sheet</h2>
      <form @submit.prevent="submitForm">
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
            <input type="text" id="middlename" v-model="formData.middlename" required>
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
            <input type="text" id="placeOfBirth" v-model="formData.placeOfBirth" required>
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
              <select id="dualType" v-model="formData.dualType" required>
                <option value="">--Select Type--</option>
                <option value="By Birth">By Birth</option>
                <option value="By Naturalization">By Naturalization</option>
              </select>
            </div>
            <div class="form-group">
              <label for="dualCountry">Country:</label>
              <input type="text" id="dualCountry" v-model="formData.dualCountry" required>
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
            <select id="civilStatus" v-model="formData.civilStatus" required>
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
            <div v-if="warningMessage" class="warning-message">
              {{ warningMessage }}
            </div>
          </div>
          <button type="button" class="next-button" @click="goTo('/address')">Next</button>
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
        surname: '',
        firstname: '',
        middlename: '',
        extname: '',
        dob: '',
        placeOfBirth: '',
        sex: '',
        citizenship: '',
        dualType: '',
        dualCountry: '',
        height: '',
        weight: '',
        bloodType: '',
        civilStatus: '',
        email: ''
      },
      warningMessage: '',
      photoDataUrl: ''
    };
  },
  methods: {
    submitForm() {
      if (this.isFormValid()) {
        this.saveForm();
      } else {
        this.warningMessage = 'Please complete the form before proceeding.';
      }
    },
    isFormValid() {
      const isDual = this.formData.citizenship === 'Dual';
      const isDualValid = !isDual || (this.formData.dualType && this.formData.dualCountry);

      const areFieldsValid = Object.values(this.formData).every(field => {
        if (typeof field === 'string') {
          return field.trim() !== '';
        }
        return field !== null && field !== undefined;
      });

      return areFieldsValid && this.formData.sex && isDualValid;
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
          this.goTo('/address');
        })
        .catch(error => {
          console.error('Error saving form data:', error);
          this.warningMessage = 'Error saving form data.';
        });
    },
    saveFormToLocalStorage() {
      localStorage.setItem('formData', JSON.stringify(this.formData));
    },
    loadFormDataFromLocalStorage() {
      const savedData = localStorage.getItem('formData');
      if (savedData) {
        this.formData = JSON.parse(savedData);
      }
    }
  },
  created() {
    this.loadFormDataFromLocalStorage();
  },
  watch: {
    formData: {
      handler() {
        this.saveFormToLocalStorage();
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.main-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 15px;
  padding: 50px;
  margin-top: 5%;
}

.basic-form {
  margin-left: 190px;
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
  margin-bottom: 15px;
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
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}

.next-button {
  background-color: #187b0d;
  color: white;
  border: none;
  cursor: pointer;
  padding: 12px;
  font-size: 1em;
  margin-right: 20px;
  width: 100px;
}

.next-button:hover {
  background-color: #145a09;
}

.upload-container {
  width: 200px;
  padding: 10px;
  background-color: #e0e0e0;
  border: 1px solid #ccc;
  border-radius: 8px;
  text-align: center;
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


<!--async fetchLoggedStudent_id () {
      try {
      const response = await axios.get("/get-student-id");
      return response.data.student_id;
      }catch (error) {
      console.error("Error getting logged-in Student ID", error);
      throw error;}
  },-->