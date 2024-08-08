<template>
    <div class="main-container">
      <!-- Degree Selection Section -->
      <div class="degree-selection">
        <div class="title-section">
          <h1>Education Information</h1>
        </div>
        <label for="degreeSelect">Select Degree:</label>
        <select id="degreeSelect" v-model="selectedDegree" @change="showOverlay">
          <option value="">--Select Degree--</option>
          <option v-for="degree in availableDegrees" :key="degree" :value="degree">{{ degree }}</option>
        </select>
      </div>

      <!-- Form Overlay -->
      <div v-if="showForm" class="form-overlay">
        <div class="form-popup">
          <h2>Add Education</h2>
          <form @submit.prevent="submitForm" class="education-form">
            <div class="form-row">
              <div class="form-group">
                <label for="degree">Degree:</label>
                <input type="text" id="degree" v-model="formData.degree" :disabled="!isAddingNewDegree">
              </div>
              <div class="form-group">
                <label for="institution">Institution:</label>
                <input type="text" id="institution" v-model="formData.institution">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" v-model="formData.address">
              </div>
              <div class="form-group">
                <label for="yearOfGraduation">Year Graduated:</label>
                <input type="number" id="yearOfGraduation" v-model="formData.yearOfGraduation">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="basicEducation">Basic Education:</label>
                <input type="text" id="basicEducation" v-model="formData.basicEducation">
              </div>
              <div class="form-group">
                <label for="highestLevel">Highest Level:</label>
                <input type="text" id="highestLevel" v-model="formData.highestLevel">
              </div>
            </div>
            <p v-if="warningMessage" class="warning-message">{{ warningMessage }}</p>
            <div class="form-actions">
              <button type="submit" class="submit-button" :disabled="isSubmitting">Save</button>
              <button type="button" class="close-button" @click="closeForm">Close</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Results Section -->
      <div v-if="filteredEducationEntries.length" class="results-section">
        <table class="result-table">
          <thead>
            <tr>
              <th>Degree</th>
              <th>Institution</th>
              <th>Address</th>
              <th>Year Graduated</th>
              <th>Basic Education</th>
              <th>Highest Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, index) in filteredEducationEntries" :key="index" class="result-row">
              <td>{{ entry.degree }}</td>
              <td>{{ entry.institution }}</td>
              <td>{{ entry.address }}</td>
              <td>{{ entry.yearOfGraduation }}</td>
              <td>{{ entry.basicEducation }}</td>
              <td>{{ entry.highestLevel }}</td>
              <td><button @click="removeEntry(index)" class="remove-button">Remove</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        educationEntries: [],
        formData: {
          degree: '',
          institution: '',
          address: '',
          yearOfGraduation: '',
          basicEducation: '',
          highestLevel: ''
        },
        availableDegrees: [],
        selectedDegree: '',
        showForm: false,
        isSubmitting: false,
        warningMessage: '',
        isAddingNewDegree: true
      };
    },
    async mounted() {
      await this.loadEducationEntries();
    },
    computed: {
      filteredEducationEntries() {
        if (!this.selectedDegree) {
          return this.educationEntries;
        }
        return this.educationEntries.filter(entry => entry.degree === this.selectedDegree);
      }
    },
    methods: {
      async loadEducationEntries() {
        try {
          const response = await axios.get('/education');
          this.educationEntries = response.data;
          this.updateAvailableDegrees();
        } catch (error) {
          console.error('Error loading education entries:', error);
        }
      },
      async submitForm() {
        if (!this.formData.degree || !this.formData.institution || !this.formData.yearOfGraduation) {
          this.warningMessage = 'Please fill in all required fields.';
          return;
        }

        this.isSubmitting = true;
        try {
          await axios.post('/education', this.formData);
          this.educationEntries.push({ ...this.formData }); // Ensure form data is pushed correctly
          this.closeForm();
          this.warningMessage = '';
          this.updateAvailableDegrees();
        } catch (error) {
          console.error('Error submitting education entry:', error);
          this.warningMessage = error.response?.data?.message || 'Error submitting education entry. Please try again.';
        } finally {
          this.isSubmitting = false;
        }
      },
      async removeEntry(index) {
        if (!confirm('Are you sure you want to remove this entry?')) {
          return;
        }
        const entryToRemove = this.educationEntries[index];

        try {
          // Send DELETE request to backend
          await axios.delete(`/education/${entryToRemove.id}`);

          // Remove entry from local array if deletion is successful
          this.educationEntries.splice(index, 1);
          this.updateAvailableDegrees();
        } catch (error) {
          console.error('Error removing education entry:', error);
          alert('Failed to remove entry. Please try again.');
        }
      },
      updateAvailableDegrees() {
        const allPossibleDegrees = ['Elementary', 'Junior High', 'Senior High', 'Vocational', 'Tertiary', 'Post-Graduate'];
        const degrees = new Set(this.educationEntries.map(entry => entry.degree));
        this.availableDegrees = allPossibleDegrees.filter(degree => !degrees.has(degree));
      },
      showOverlay() {
        if (this.selectedDegree) {
          this.showForm = true;
          this.formData.degree = this.selectedDegree;
          this.selectedDegree = ''; // Reset the dropdown to --Select Degree--
        } else {
          this.showForm = false;
        }
      },
      closeForm() {
        this.formData = {
          degree: '',
          institution: '',
          address: '',
          yearOfGraduation: '',
          basicEducation: '',
          highestLevel: ''
        };
        this.selectedDegree = ''; // Reset selected degree
        this.showForm = false;
      }
    }
  };
  </script>

  <style scoped>
.main-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 50px;
  margin-left: 120px;
}

.degree-selection {
  width: 90%;
  max-width: 100%;
  padding: 20px;
  background-color: rgba(240, 240, 240, 0.8);
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  text-align: left;
  margin-top: 5%;
  margin-left: 60px;
}

.degree-selection label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  font-size: 1.1em;
}

select {
  width: 90%;
  padding: 10px;
  font-size: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
  margin-bottom: 10px;
}

.form-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.form-popup {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 20px;
  width: 90%;
  max-width: 600px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.education-form {
  display: flex;
  flex-direction: column;
}

.form-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  gap: 20px;
}

.form-group {
  flex: 1;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input:disabled {
  background-color: #f9f9f9;
}

.warning-message {
  color: red;
  font-weight: bold;
}

.form-actions {
  display: flex;
  gap: 10px;
}

.submit-button,
.close-button,
.remove-button {
  width: 100px;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button {
  background-color: #28a745;
  color: white;
}

.close-button {
  background-color: #dc3545;
  color: white;
}

.remove-button {
  background-color: #dc3545;
  color: white;
}

.results-section {
  width: 90%;
  max-width: 100%;
  margin-top: 20px;
}

.result-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.result-table thead th {
  background-color: #187b0d;
  color: white;
  font-weight: bold;
  border: none;
}

.result-table th,
.result-table td {
  padding: 10px;
  text-align: left;
}

.result-table td {
  border-top: 1px solid #ccc; /* Remove vertical borders */
}

.result-row:nth-child(even) {
  background-color: #f9f9f9;
}

.result-row:hover {
  background-color: #f1f1f1;
}
</style>
