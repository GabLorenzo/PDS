<template>
    <div class="container">
      <div class="form-container">
        <div class="title-section">
          <h1>Achievements</h1>
        </div>
        <div v-if="!showForm">
          <button @click="showOverlay" class="add-button">Add Award</button>
        </div>
  
        <div v-if="showForm">
          <form @submit.prevent="submitForm">
            <div class="select-container">
              <label>Select Award Type:</label>
              <select v-model="awardType" required class="custom-select">
                <option value="" disabled>-- Select Award Type --</option>
                <option value="Educational">Educational Award</option>
                <option value="Job">Job Award</option>
              </select>
            </div>
  
            <div v-if="awardType">
              <div class="form-group">
                <label for="awardTitle">Award Title:</label>
                <input type="text" id="awardTitle" v-model="formData.awardTitle" placeholder="Award Title" required class="form-input">
                <span v-if="errors.awardTitle" class="error-message">{{ errors.awardTitle[0] }}</span>
              </div>
  
              <div class="form-group">
                <label for="awardDescription">Award Description:</label>
                <input type="text" id="awardDescription" v-model="formData.awardDescription" placeholder="Award Description" required class="form-input">
                <span v-if="errors.awardDescription" class="error-message">{{ errors.awardDescription[0] }}</span>
              </div>
            </div>
  
            <div class="button-container">
              <button type="submit" :disabled="isSubmitting" class="submit-button">Submit</button>
              <button type="button" @click="closeForm" class="prev-button">Cancel</button>
            </div>
          </form>
  
          <div v-if="warningMessage" class="warning-message">{{ warningMessage }}</div>
        </div>
      </div>
  
      <div class="result-container">
        <table v-if="awardEntries.length" class="result-table">
          <thead>
            <tr>
              <th>Award Type</th>
              <th>Award Name</th>
              <th>Award Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, index) in awardEntries" :key="entry.id" class="result-row">
              <td>{{ entry.awardType }}</td>
              <td>{{ entry.name }}</td>
              <td>{{ entry.description }}</td>
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
        awardEntries: [],
        formData: {
          awardTitle: '',
          awardDescription: ''
        },
        showForm: false,
        isSubmitting: false,
        warningMessage: '',
        awardType: '',
        errors: {}
      };
    },
    async mounted() {
      await this.loadAwardEntries();
    },
    methods: {
      showOverlay() {
        this.showForm = true;
      },
      closeForm() {
        this.formData = {
          awardTitle: '',
          awardDescription: ''
        };
        this.awardType = '';
        this.errors = {};
        this.showForm = false;
      },
      async loadAwardEntries() {
        try {
          const response = await axios.get('/awards');
          this.awardEntries = response.data;
        } catch (error) {
          console.error('Error loading awards:', error);
        }
      },
      async submitForm() {
        this.errors = {};
  
        if (!this.formData.awardTitle || !this.formData.awardDescription || !this.awardType) {
          this.warningMessage = 'Please fill in all required fields.';
          return;
        }
  
        this.isSubmitting = true;
        try {
          const response = await axios.post('/awards', {
            name: this.formData.awardTitle,
            description: this.formData.awardDescription,
            awardType: this.awardType
          });
  
          this.awardEntries.push(response.data);
          this.closeForm();
          this.warningMessage = '';
          alert('Award saved successfully.');
        } catch (error) {
          console.error('Error submitting award:', error);
          this.errors = error.response?.data?.errors || {};
          this.warningMessage = error.response?.data?.message || 'Error submitting award. Please try again.';
        } finally {
          this.isSubmitting = false;
        }
      },
      async removeEntry(index) {
        if (!confirm('Are you sure you want to remove this entry?')) {
          return;
        }
  
        const entryToRemove = this.awardEntries[index];
  
        try {
          await axios.delete(`/awards/${entryToRemove.id}`);
          this.awardEntries.splice(index, 1);
          alert('Award removed successfully.');
        } catch (error) {
          console.error('Error removing award:', error);
          alert('Failed to remove award. Please try again.');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 9%;
    margin-left: 145px;
  }
  
  .form-container {
    width: 100%;
    max-width: 87%;
    padding: 20px;
    background-color: rgba(240, 240, 240, 0.8);
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    text-align: left;
    position: relative;
    margin-left: 90px;
  }
  
  .title-section {
    margin-bottom: 20px;
  }
  
  .title-section h1 {
    font-size: 1.5em;
    color: #187b0d;
  }
  
  .select-container {
    margin-bottom: 15px;
  }
  
  .select-container label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 1.1em;
  }
  
  .custom-select {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px;
    margin-bottom: 10px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .form-input {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .error-message {
    color: red;
    font-size: 0.9em;
  }
  
  .button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
  }
  
  .prev-button,
  .submit-button,
  .add-button,
  .ok-button {
    padding: 12px;
    font-size: 1em;
    width: 150px;
    box-sizing: border-box;
    margin-top: 10px;
  }
  
  .prev-button {
    background-color: #187b0d;
    color: white;
    border: none;
  }
  
  .prev-button:hover {
    background-color: #145a09;
  }
  
  .add-button {
    background-color: #187b0d;
    color: white;
    border: none;
  }
  
  .add-button:hover {
    background-color: #145a09;
  }
  
  .submit-button {
    background-color: #187b0d;
    color: white;
    border: none;
  }
  
  .submit-button:hover {
    background-color: #145a09;
  }
  
  .ok-button {
    background-color: #187b0d;
    color: white;
    border: none;
  }
  
  .ok-button:hover {
    background-color: #145a09;
  }
  
  .edit-button {
    background-color: #187b0d;
    color: white;
    border: none;
    cursor: pointer;
    padding: 12px;
    font-size: 1em;
    width: 150px;
    box-sizing: border-box;
    margin-top: 10px;
  }
  
  .edit-button:hover {
    background-color: #145a09;
  }
  
  .result-container {
    width: 100%;
    max-width: 89%;
    margin-top: 20px;
    margin-left: 75px;
  }
  
  .result-table {
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(240, 240, 240, 0.8);
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
  }
  
  .result-table thead {
    background-color: #187b0d;
    color: white;
  }
  
  .result-table th,
  .result-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  .result-table th {
    font-weight: bold;
  }
  
  .result-table td {
    font-size: 1em;
  }
  
  .result-row {
    transition: background-color 0.3s;
  }
  
  .result-row:hover {
    background-color: #f1f1f1;
  }
  
  .remove-button {
    background-color: #d9534f;
    color: white;
    border: none;
    cursor: pointer;
    padding: 8px;
    font-size: 0.9em;
    width: 100px;
    box-sizing: border-box;
    margin-top: 10px;
  }
  
  .remove-button:hover {
    background-color: #c9302c;
  }
  
  .warning-message {
    color: red;
    font-size: 1em;
    margin-top: 10px;
  }
  </style>
  