<template>
    <div class="main-container">
      <div class="degree-selection">
        <div class="title-section">
          <h1>Work Experience Information</h1>
        </div>
        <button @click="showOverlay" class="add-button">Add Work Experience</button>
      </div>

      <!-- Form Overlay -->
      <div v-if="showForm" class="form-overlay">
        <div class="form-popup">
          <h2>Add Work Experience</h2>
          <form @submit.prevent="submitForm" class="work-experience-form">
            <div class="form-row">
              <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" v-model="formData.address">
              </div>
              <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" v-model="formData.contact">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="inclusive_dates">Inclusive Dates:</label>
                <input type="text" id="inclusive_dates" v-model="formData.inclusive_dates">
              </div>
              <div class="form-group">
                <label for="position_title">Position Title:</label>
                <input type="text" id="position_title" v-model="formData.position_title">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" v-model="formData.department">
              </div>
              <div class="form-group">
                <label for="monthly_salary">Monthly Salary:</label>
                <input type="number" id="monthly_salary" v-model="formData.monthly_salary">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="salary_grade">Salary Grade:</label>
                <input type="text" id="salary_grade" v-model="formData.salary_grade">
              </div>
              <div class="form-group">
                <label for="appointment_status">Appointment Status:</label>
                <input type="text" id="appointment_status" v-model="formData.appointment_status">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="govt_service">Govt Service:</label>
                <select id="govt_service" v-model="formData.govt_service">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
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
      <div v-if="filteredWorkExperienceEntries.length" class="results-section">
        <table>
          <thead>
            <tr>
              <th>Address</th>
              <th>Contact</th>
              <th>Inclusive Dates</th>
              <th>Position Title</th>
              <th>Department</th>
              <th>Monthly Salary</th>
              <th>Salary Grade</th>
              <th>Appointment Status</th>
              <th>Govt Service</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, index) in filteredWorkExperienceEntries" :key="index">
              <td>{{ entry.address }}</td>
              <td>{{ entry.contact }}</td>
              <td>{{ entry.inclusive_dates }}</td>
              <td>{{ entry.position_title }}</td>
              <td>{{ entry.department }}</td>
              <td>{{ entry.monthly_salary }}</td>
              <td>{{ entry.salary_grade }}</td>
              <td>{{ entry.appointment_status }}</td>
              <td>{{ entry.govt_service }}</td>
              <td><button class="remove-button" @click="removeEntry(index)">Remove</button></td>
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
        workExperienceEntries: [],
        formData: {
          address: '',
          contact: '',
          inclusive_dates: '',
          position_title: '',
          department: '',
          monthly_salary: '',
          salary_grade: '',
          appointment_status: '',
          govt_service: 'No' // Default value
        },
        showForm: false,
        isSubmitting: false,
        warningMessage: ''
      };
    },
    async mounted() {
      await this.loadWorkExperienceEntries();
    },
    computed: {
      filteredWorkExperienceEntries() {
        return this.workExperienceEntries;
      }
    },
    methods: {
      async loadWorkExperienceEntries() {
        try {
          const response = await axios.get('/work-experiences');
          this.workExperienceEntries = response.data;
        } catch (error) {
          console.error('Error loading work experience entries:', error);
        }
      },
      async submitForm() {
        if (!this.formData.address || !this.formData.contact || !this.formData.inclusive_dates || !this.formData.position_title) {
          this.warningMessage = 'Please fill in all required fields.';
          return;
        }

        this.isSubmitting = true;
        try {
          await axios.post('/work-experiences', this.formData);
          this.workExperienceEntries.push({ ...this.formData }); // Ensure form data is pushed correctly
          this.closeForm();
          this.warningMessage = '';
        } catch (error) {
          console.error('Error submitting work experience entry:', error);
          this.warningMessage = error.response?.data?.message || 'Error submitting work experience entry. Please try again.';
        } finally {
          this.isSubmitting = false;
        }
      },
      async removeEntry(index) {
        if (!confirm('Are you sure you want to remove this entry?')) {
          return;
        }
        const entryToRemove = this.workExperienceEntries[index];

        try {
          // Send DELETE request to backend
          await axios.delete(`/work-experiences/${entryToRemove.id}`);

          // Remove entry from local array if deletion is successful
          this.workExperienceEntries.splice(index, 1);
        } catch (error) {
          console.error('Error removing work experience entry:', error);
          alert('Failed to remove entry. Please try again.');
        }
      },
      showOverlay() {
        this.showForm = true;
      },
      closeForm() {
        this.formData = {
          address: '',
          contact: '',
          inclusive_dates: '',
          position_title: '',
          department: '',
          monthly_salary: '',
          salary_grade: '',
          appointment_status: '',
          govt_service: 'No' // Reset to default value
        };
        this.showForm = false;
      }
    }
  }
  </script>

  <style scoped>
  .main-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px;
    margin-top: 60px;
  }

  .degree-selection {
    width: 90%;
    max-width: 80%;
    padding: 20px;
    background-color: rgba(240, 240, 240, 0.8);
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    text-align: left;
    margin-left: 150px;
  }

  .title-section {
    margin-bottom: 20px;
  }

  .add-button {
    padding: 10px;
    font-size: 1em;
    border: none;
    border-radius: 4px;
    background-color: #28a745;
    color: white;
    cursor: pointer;
    margin-top: 10px;
    width: 100px;
  }

  .add-button:hover {
    background-color: #218838;
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
    padding: 30px;
    width: 90%;
    max-width: 800px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  h2 {
    margin-bottom: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  .work-experience-form {
    display: flex;
    flex-direction: column;
  }

  .form-row {
    display: flex;
    margin-bottom: 20px;
  }

  .form-group {
    flex: 1;
    margin-right: 15px;
  }

  .form-group:last-child {
    margin-right: 0;
  }

  form input[type="text"],
  form input[type="number"],
  form select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1em;
    margin-bottom: 10px;
  }

  .submit-button {
    padding: 10px;
    font-size: 1em;
    border: none;
    border-radius: 4px;
    background-color: #28a745;
    color: white;
    cursor: pointer;
    margin-right: 10px;
    width: 100px;
  }

  .submit-button:hover {
    background-color: #218838;
  }

  .close-button {
    padding: 10px;
    font-size: 1em;
    border: none;
    border-radius: 4px;
    background-color: #dc3545;
    color: white;
    cursor: pointer;
    width: 100px;
  }

  .close-button:hover {
    background-color: #c82333;
  }

  .warning-message {
    color: #dc3545;
    margin-top: 10px;
  }

  .results-section {
    width: 90%;
    max-width: 80%;
    margin-top: 20px;
    margin-left: 110px;
  }

  .results-section table {
    width: 100%;
    border-collapse: collapse;
  }

  .results-section th,
  .results-section td {
    padding: 10px;
    text-align: left;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .results-section thead {
    background-color: #187b0d;
    color: white;
    font-weight: bold;
    font-size: 13px;
  }

  .results-section tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .results-section tbody tr:hover {
    background-color: #e9f5e9;
  }

  .remove-button {
    padding: 5px 10px;
    font-size: 0.9em;
    border: none;
    border-radius: 4px;
    background-color: #dc3545;
    color: white;
    cursor: pointer;
  }

  .remove-button:hover {
    background-color: #c82333;
  }
  </style>
