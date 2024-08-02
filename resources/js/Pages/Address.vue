<template>
  <div class="main-container">
    <div class="basic-form">
      <h2>Address Information</h2>
      <form @submit.prevent="submitForm">
        <!-- Address Type Selection -->
        <div class="form-row">
          <div class="form-group">
            <label>Type:</label>
            <div class="radio-group">
              <label>
                <input type="radio" v-model="formData.addressType" value='0' required> Permanent
              </label>
              <label>
                <input type="radio" v-model="formData.addressType" value='1' required> Temporary
              </label>
            </div>
          </div>
        </div>

        <!-- Permanent Address Form -->
        <div v-if="formData.addressType === '0' " class="address-form">
          <h3>Permanent Address (Required)</h3>
          <div class="form-row">
            <div class="form-group">
              <label for="country">Country:</label>
              <input type="text" id="country" v-model="formData.country" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="province">Province:</label>
              <input type="text" id="province" v-model="formData.province" required>
            </div>

            <div class="form-group">
              <label for="city">City/Town:</label>
              <input type="text" id="city" v-model="formData.city" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="barangay">Barangay:</label>
              <input type="text" id="barangay" v-model="formData.barangay" required>
            </div>

            <div class="form-group">
              <label for="houseNumber">House Number/Street/Subdivision:</label>
              <input type="text" id="houseNumber" v-model="formData.houseNumber" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="zipCode">ZIP Code:</label>
              <input type="text" id="zipCode" v-model="formData.zipCode" required>
            </div>
          </div>
        </div>

        <!-- Temporary Address Form -->
        <div v-if="formData.addressType === '1'" class="address-form">
          <h3>Temporary Address</h3>
          <div class="form-row">
            <div class="form-group">
              <label for="tempCountry">Country:</label>
              <input type="text" id="tempCountry" v-model="formData.tempCountry">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="tempProvince">Province:</label>
              <input type="text" id="tempProvince" v-model="formData.tempProvince">
            </div>

            <div class="form-group">
              <label for="tempCity">City/Town:</label>
              <input type="text" id="tempCity" v-model="formData.tempCity">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="tempBarangay">Barangay:</label>
              <input type="text" id="tempBarangay" v-model="formData.tempBarangay">
            </div>

            <div class="form-group">
              <label for="tempHouseNumber">House Number/Street/Subdivision:</label>
              <input type="text" id="tempHouseNumber" v-model="formData.tempHouseNumber">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="tempZipCode">ZIP Code:</label>
              <input type="text" id="tempZipCode" v-model="formData.tempZipCode">
            </div>
          </div>
        </div>

        <div v-if="warningMessage" class="warning-message">
          {{ warningMessage }}
        </div>

        <div class="form-buttons">
          <button type="button" class="prev-button" @click="goTo('/basic')">Previous</button>
          <button type="button" class="save-button" @click="submitForm">Save</button>
          <button type="button" class="next-button" @click="goTo('/family')">Next</button>
        </div>
      </form>

      <!-- Results Section -->
      <div v-if="formSubmitted" class="form-results">
        <h3>Submitted Address Information</h3>
        <p v-if="formData.addressType === 'Permanent'">Country: {{ formData.country }}</p>
        <p v-if="formData.addressType === 'Permanent'">Province: {{ formData.province }}</p>
        <p v-if="formData.addressType === 'Permanent'">City/Town: {{ formData.city }}</p>
        <p v-if="formData.addressType === 'Permanent'">Barangay: {{ formData.barangay }}</p>
        <p v-if="formData.addressType === 'Permanent'">House Number/Street/Subdivision: {{ formData.houseNumber }}</p>
        <p v-if="formData.addressType === 'Permanent'">ZIP Code: {{ formData.zipCode }}</p>

        <p v-if="formData.addressType === 'Temporary'">Country: {{ formData.tempCountry }}</p>
        <p v-if="formData.addressType === 'Temporary'">Province: {{ formData.tempProvince }}</p>
        <p v-if="formData.addressType === 'Temporary'">City/Town: {{ formData.tempCity }}</p>
        <p v-if="formData.addressType === 'Temporary'">Barangay: {{ formData.tempBarangay }}</p>
        <p v-if="formData.addressType === 'Temporary'">House Number/Street/Subdivision: {{ formData.tempHouseNumber }}</p>
        <p v-if="formData.addressType === 'Temporary'">ZIP Code: {{ formData.tempZipCode }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        addressType: '',
        country: '',
        province: '',
        city: '',
        barangay: '',
        houseNumber: '',
        zipCode: '',
        tempCountry: '',
        tempProvince: '',
        tempCity: '',
        tempBarangay: '',
        tempHouseNumber: '',
        tempZipCode: ''
      },
      formSubmitted: false,
      warningMessage: ''
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
      if (!this.formData.addressType) {
        return false; // No address type selected
      }

      if (this.formData.addressType === '0') {
        return [
          this.formData.addressType,
          this.formData.country,
          this.formData.province,
          this.formData.city,
          this.formData.barangay,
          this.formData.houseNumber,
          this.formData.zipCode
        ].every(field => field.trim() !== '');
      }

      if (this.formData.addressType === '1') {
        return [
          this.formData.addressType,
          this.formData.tempCountry,
          this.formData.tempProvince,
          this.formData.tempCity,
          this.formData.tempBarangay,
          this.formData.tempHouseNumber,
          this.formData.tempZipCode
        ].every(field => field.trim() !== '');
      }

      return false; // Invalid addressType
    },
    saveForm() {
      axios.post('/address-info', this.formData)
        .then(response => {
          this.warningMessage = 'Form data saved successfully!';
          this.formSubmitted = true;
          this.goTo('/family');
        })
        .catch(error => {
          console.error('Error saving form data:', error);
          this.warningMessage = 'Error saving form data.';
        });
    },
    goTo(route) {
      if (route === '/family' && !this.isFormValid()) {
        this.warningMessage = 'Please complete the form before proceeding.';
      } else {
        this.warningMessage = '';
        this.$router.push(route);
      }
    }
  }
};
</script>

<style scoped>
.main-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 30px;
  padding: 50px;
  padding-top: 0px;
  margin-top: 9%;
}

.basic-form {
  margin-left: 150px;
  width: 100%;
  max-width: 80%;
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

input[type="text"] {
  width: 90%;
  padding: 10px;
  font-size: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
  margin-bottom: 10px;
}

.radio-group {
  margin-top: 20px;
  margin-left: 12px;
  display: flex;
  gap: 15px;
}

.address-form {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.warning-message {
  color: red;
  margin-top: 10px;
}

.form-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  margin-right: 40px;
}

.prev-button, .next-button {
  background-color: #187b0d;
  color: white;
  border: none;
  cursor: pointer;
  padding: 12px;
  font-size: 1em;
  box-sizing: border-box;
  width: 100px; 
  text-align: center;
}

.prev-button:hover, .next-button:hover {
  background-color: #145a09;
}

.prev-button {
  background-color: #187b0d; 
}

.prev-button:hover {
  background-color: #145a09; 
}

.form-results {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
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
}
</style>
