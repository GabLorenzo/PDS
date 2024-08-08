    <template>
        <div class="main-container">
        <!-- Basic Form -->
        <div class="basic-form">
            <h2>Family Information</h2>
            <div class="form-row">
            <div class="form-group">
                <label for="selectRelation">Select Relation:</label>
                <select id="selectRelation" v-model="selectedRelation" @change="updateRelation">
                <option value="">--Select Relation--</option>
                <option v-for="relation in availableRelations" :key="relation" :value="relation">
                    {{ relation }}
                </option>
                </select>
            </div>
            </div>

            <!-- Buttons inside basic-form -->
            <!-- <div class="button-row">
            <router-link to="/address">
                <button class="nav-button">Previous</button>
            </router-link>
            <router-link to="/education">
                <button class="nav-button">Next</button>
            </router-link>
            </div> -->
        </div>

        <!-- Form Overlay -->
        <div v-if="showForm" class="form-overlay">
            <div class="form-popup">
            <h2>Family Information</h2>
            <form @submit.prevent="submitForm">
                <div class="form-row">
                <div class="form-group">
                    <label for="relation">Relation:</label>
                    <select id="relation" v-model="formData.relation" disabled>
                    <option value="">--Select Relation--</option>
                    <option v-for="relation in availableRelations" :key="relation" :value="relation">
                        {{ relation }}
                    </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" v-model="formData.name">
                </div>
                </div>

                <div class="form-row">
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" v-model="formData.age">
                </div>
                </div>

                <div class="form-row">
                <div class="form-group">
                    <label for="occupation">Occupation:</label>
                    <input type="text" id="occupation" v-model="formData.occupation">
                </div>
                </div>

                <div class="form-row">
                <div class="form-group">
                    <label for="contactNumber">Contact Number:</label>
                    <input type="text" id="contactNumber" v-model="formData.contactNumber">
                </div>
                </div>

                <p v-if="warningMessage" class="warning-message">{{ warningMessage }}</p>
                <button type="submit" class="submit-button" :disabled="isSubmitting">Add</button>
                <button type="button" class="close-button" @click="closeForm">Close</button>
            </form>
            </div>
        </div>

        <!-- Results Display -->
        <div v-if="familyMembers.length" class="result-container">
            <table class="result-table">
            <thead>
                <tr>
                <th>Relation</th>
                <th>Name</th>
                <th>Age</th>
                <th>Occupation</th>
                <th>Contact Number</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(member, index) in filteredFamilyMembers" :key="index" class="result-row">
                <td>{{ member.relation }}</td>
                <td>{{ member.name }}</td>
                <td>{{ member.age }}</td>
                <td>{{ member.occupation }}</td>
                <td>{{ member.contactNumber }}</td>
                <td><button @click="removeMember(index, member.id)" class="remove-button">Remove</button></td>
                </tr>
            </tbody>
            </table>
            <button class="submit-button" @click="submitToDatabase" :disabled="isSubmitting">Submit</button>
        </div>
        </div>
    </template>

    <script>
    import axios from 'axios';

    export default {
        data() {
        return {
            familyMembers: [],
            selectedRelation: '',
            formData: {
            relation: '',
            name: '',
            age: '',
            occupation: '',
            contactNumber: '',
            user_id: '' // Add user_id here
            },
            showForm: false,
            isSubmitting: false,
            warningMessage: '',
            availableRelations: ['Father', 'Mother', 'Sibling', 'Spouse', 'Child']
        };
        },
        created() {
        this.fetchFamilyMembers();
        this.fetchUserId(); // Fetch user ID on component creation
        },
        methods: {
        async fetchFamilyMembers() {
            try {
            const response = await axios.get('/family');
            this.familyMembers = Array.isArray(response.data) ? response.data : [];
            } catch (error) {
            console.error('Error fetching family members:', error);
            this.familyMembers = []; // Default to empty array on error
            }
        },
        async fetchUserId() {
            try {
            const response = await axios.get('/user');
            this.formData.user_id = response.data.user.username; // Assuming user ID is in username
            } catch (error) {
            console.error('Error fetching user ID:', error);
            this.warningMessage = 'Unable to retrieve user ID.';
            }
        },
        updateRelation() {
            if (this.selectedRelation) {
            this.formData.relation = this.selectedRelation;
            this.showForm = true;
            } else {
            this.showForm = false;
            }
        },
        async submitForm() {
            if (!this.formData.relation || !this.formData.name) {
            this.warningMessage = 'Please fill in all required fields.';
            return;
            }

            this.isSubmitting = true;
            try {
            const formDataWithUserId = { ...this.formData, user_id: this.formData.user_id };
            const response = await axios.post('/family', formDataWithUserId);

            this.familyMembers.push(response.data);
            this.closeForm();
            this.warningMessage = '';
            } catch (error) {
            console.error('Error submitting family member:', error);
            this.warningMessage = error.response ? (error.response.data.message || 'Error submitting family member. Please try again.') : 'Error submitting family member. Please try again.';
            } finally {
            this.isSubmitting = false;
            }
        },
        async submitToDatabase() {
            if (this.familyMembers.length === 0) {
            this.warningMessage = 'No family members to submit';
            return;
            }

            this.isSubmitting = true;
            try {
            await axios.post('/family/bulk', { familyMembers: this.familyMembers });
            alert('Family members submitted successfully!');
            this.warningMessage = '';
            } catch (error) {
            console.error('Error submitting family members:', error);
            alert('Error submitting family members. Please try again.');
            this.warningMessage = 'Error submitting family members. Please try again.';
            } finally {
            this.isSubmitting = false;
            }
        },
        closeForm() {
            this.formData = {
            relation: '',
            name: '',
            age: '',
            occupation: '',
            contactNumber: ''
            };
            this.selectedRelation = '';
            this.showForm = false;
        },
        async removeMember(index, id) {
            if (!confirm('Are you sure you want to remove this member?')) {
            return;
            }

            try {
            await axios.delete(`/family/${id}`);
            this.familyMembers.splice(index, 1);
            } catch (error) {
            console.error('Error removing family member:', error);
            alert('Error removing family member. Please try again.');
            }
        }
        },
        computed: {
        filteredFamilyMembers() {
            return this.familyMembers.filter(member =>
            member.relation || member.name || member.age || member.occupation || member.contactNumber
            );
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
    }

    .basic-form {
        width: 100%;
        max-width: 85%;
        padding: 20px;
        background-color: rgba(240, 240, 240, 0.8);
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: left;
        margin-top: 5%;
        margin-left: 220px;
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
    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .submit-button,
    .close-button,
    .nav-button,
    .remove-button {
        width: 100px;
    }

    .submit-button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        margin-left:90px;
        margin-top: 10px;
    }

    .nav-button {
        background-color: #2196F3;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
    }

    .remove-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        border-radius: 4px;
    }

    .close-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
    }

    .form-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-popup {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
    }

    .result-container {
        width: 100%;
        max-width: 85%;
        margin: 20px 0;
    }

    .result-table {
    width: 100%;
    border-collapse: collapse;
    margin-left: 90px;
}

.result-table th,
.result-table td {
    border: none; /* Remove vertical lines */
    padding: 8px;
    text-align: left;
}

.result-table th {
    background-color: #187b0d;
    color: white;
}

.result-row:nth-child(even) {
    background-color: #f2f2f2;
}

.remove-button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
}
    </style>
