<template>
    <div class="main-container">
        <form class="basic-form" @submit.prevent="submitAddress">

            <!-- Buttons to switch between forms -->
            <div class="form-controls">
                <h3>Address Information</h3>
                <button type="button" class="toggle-button" @click="showTemporaryForm = false">Permanent</button>
                <button type="button" class="toggle-button" @click="showTemporaryForm = true">Temporary</button>
            </div>

            <!-- Conditionally render the address forms based on the button click -->
            <div v-if="!showTemporaryForm" class="address-form">
                <h3>Permanent Address (Required)</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="permanent_country">Country:</label>
                        <input type="text" v-model="address.permanent.country" required>
                    </div>
                    <div class="form-group">
                        <label for="permanent_province">Province:</label>
                        <input type="text" v-model="address.permanent.province" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="permanent_city">City:</label>
                        <input type="text" v-model="address.permanent.city" required>
                    </div>
                    <div class="form-group">
                        <label for="permanent_barangay">Barangay:</label>
                        <input type="text" v-model="address.permanent.barangay" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="permanent_house_number">House Number:</label>
                        <input type="text" v-model="address.permanent.house_number" required>
                    </div>
                    <div class="form-group">
                        <label for="permanent_zip_code">Zip Code:</label>
                        <input type="text" v-model="address.permanent.zip_code" required>
                    </div>
                </div>
            </div>

            <div v-if="showTemporaryForm" class="address-form">
                <h3>Temporary Address (Optional)</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="temporary_country">Country:</label>
                        <input type="text" v-model="address.temporary.country">
                    </div>
                    <div class="form-group">
                        <label for="temporary_province">Province:</label>
                        <input type="text" v-model="address.temporary.province">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="temporary_city">City:</label>
                        <input type="text" v-model="address.temporary.city">
                    </div>
                    <div class="form-group">
                        <label for="temporary_barangay">Barangay:</label>
                        <input type="text" v-model="address.temporary.barangay">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="temporary_house_number">House Number:</label>
                        <input type="text" v-model="address.temporary.house_number">
                    </div>
                    <div class="form-group">
                        <label for="temporary_zip_code">Zip Code:</label>
                        <input type="text" v-model="address.temporary.zip_code">
                    </div>
                </div>
            </div>

            <div class="save-button-container">
                <button type="submit" class="save-button">Save</button>
            </div>
        </form>
    </div>
</template>


    <script>
    import axios from 'axios';

    export default {
        data() {
        return {
            address: {
            permanent: {
                country: '',
                province: '',
                city: '',
                barangay: '',
                house_number: '',
                zip_code: ''
            },
            temporary: {
                country: '',
                province: '',
                city: '',
                barangay: '',
                house_number: '',
                zip_code: ''
            }
            },
            showTemporaryForm: false, // Control which form to display
            user_id: null // Initialize user_id
        };
        },
        created() {
        this.fetchUserId();
        },
        methods: {
        fetchUserId() {
            axios.get('/personal-info') // Adjust this endpoint as needed
            .then(response => {
                this.user_id = response.data.user_id;
            })
            .catch(error => {
                console.error('There was an error fetching the user ID:', error);
            });
        },
        submitAddress() {
            const data = {
            ...this.address,
            user_id: this.user_id
            };

            axios.post('/address', data)
            .then(response => {
                alert('Addresses saved successfully');
                this.goTo('/family');
            })
            .catch(error => {
                console.error('There was an error!', error);
                alert('Please fill up the Permanent address first');
            });
        }
        }
    }
    </script>

    <style scoped>
    .main-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 30px;
  padding: 50px;
  padding-top: 0px;
  margin-top: 8%;
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
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.form-controls {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-bottom: 10px;
  gap: 5px;
}

.form-controls h3 {
  margin: 0;
  font-size: 30px;
  font-weight: bold;
  color: black;
  margin-right: 580px;
  display: flex;
}

.toggle-button {
  background-color: #187b0d;
  color: white;
  border: none;
  cursor: pointer;
  padding: 12px;
  font-size: 15px;
  box-sizing: border-box;
  text-align: left;
  width: 100px;
  height: auto;
}

.toggle-button:hover {
  background-color: #145a09;
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

.address-form {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.save-button-container {
  display: flex;
  justify-content: flex-end;
  margin-top: auto; /* Push the button container to the bottom */
}

.save-button {
  background-color: #187b0d;
  color: white;
  border: none;
  cursor: pointer;
  padding: 12px;
  font-size: 15px;
  box-sizing: border-box;
  width: 100px;
  text-align: center; /* Center text inside button */
  margin-top: 20px;
}

.save-button:hover {
  background-color: #145a09;
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

  .form-controls {
    flex-direction: column;
    align-items: flex-start;
  }

  .form-controls h3 {
    margin-bottom: 10px;
  }

  .toggle-button {
    width: 100%;
    margin-top: 5px;
  }
}
</style>
