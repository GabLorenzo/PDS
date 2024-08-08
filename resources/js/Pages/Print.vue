<template>
    <div class="pds-container">
      <h1>Personal Data Sheet</h1>

      <!-- Personal Information Section -->
      <section class="pds-section">
        <h2>Personal Information</h2>
        <table class="pds-table">
          <tbody>
            <tr><td class="pds-label">Surname:</td><td class="pds-data">{{ formData.surname || 'N/A' }}</td></tr>
            <tr><td class="pds-label">First Name:</td><td class="pds-data">{{ formData.firstname || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Middle Name:</td><td class="pds-data">{{ formData.middlename || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Extension Name:</td><td class="pds-data">{{ formData.extname || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Date of Birth:</td><td class="pds-data">{{ formData.dob || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Place of Birth:</td><td class="pds-data">{{ formData.placeOfBirth || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Sex:</td><td class="pds-data">{{ formData.sex || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Citizenship:</td><td class="pds-data">{{ formData.citizenship || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Height:</td><td class="pds-data">{{ formData.height || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Weight:</td><td class="pds-data">{{ formData.weight || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Blood Type:</td><td class="pds-data">{{ formData.bloodType || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Civil Status:</td><td class="pds-data">{{ formData.civilStatus || 'N/A' }}</td></tr>
            <tr><td class="pds-label">Email:</td><td class="pds-data">{{ formData.email || 'N/A' }}</td></tr>
          </tbody>
        </table>
      </section>


  <!-- Contact Information Section -->
  <section class="pds-section">
      <h2>Contact Information</h2>
      <table class="pds-table">
        <tbody>
          <tr>
            <td class="pds-label">Address Type:</td>
            <td class="pds-data">
              {{ formData.addressType || 'N/A' }}
            </td>
          </tr>
          <tr>
            <td class="pds-label">Address:</td>
            <td class="pds-data">
              {{ formData.houseNumberStreetSubdivision || 'N/A' }}
              {{ formData.barangay || 'N/A' }}
              {{ formData.cityTown || 'N/A' }}
              {{ formData.province || 'N/A' }}
              {{ formData.country || 'N/A' }}
              {{ formData.zipCode || 'N/A' }}
            </td>
          </tr>
          <tr>
            <td class="pds-label">Contact Number:</td>
            <td class="pds-data">{{ formData.contactNumber || 'N/A' }}</td>
          </tr>
        </tbody>
      </table>
    </section>

        <!-- Family Section -->
        <section class="family-section">
          <h2>Family</h2>
          <table class="family-table">
            <thead>
              <tr>
                <th class="family-header">Relation</th>
                <th class="family-header">Name</th>
                <th class="family-header">Age</th>
                <th class="family-header">Occupation</th>
                <th class="family-header">Contact Number</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="formData.family.length === 0">
                <td colspan="5">No family information provided.</td>
              </tr>
              <tr v-for="(familyMember, index) in formData.family" :key="index">
                <td class="family-data">{{ familyMember.relation || 'N/A' }}</td>
                <td class="family-data">{{ familyMember.name || 'N/A' }}</td>
                <td class="family-data">{{ familyMember.age || 'N/A' }}</td>
                <td class="family-data">{{ familyMember.occupation || 'N/A' }}</td>
                <td class="family-data">{{ familyMember.contactNumber || 'N/A' }}</td>
              </tr>
            </tbody>
          </table>
        </section>



      <!-- Education Section -->
      <section class="pds-section">
        <h2>Education</h2>
        <table class="pds-table">
          <thead>
            <tr>
              <th>Level</th>
              <th>School Name</th>
              <th>School Address</th>
              <th>Year Graduated</th>
              <th>Degree/Course</th>
              <th>Highest Level/Units Earned</th>
              <th>Honors Received</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(edu, index) in formData.education" :key="index">
              <td>{{ edu.level }}</td>
              <td>{{ edu.schoolName }}</td>
              <td>{{ edu.schoolAddress }}</td>
              <td>{{ edu.yearGraduated }}</td>
              <td>{{ edu.degreeCourse }}</td>
              <td>{{ edu.highestLevelUnits }}</td>
              <td>{{ edu.honorsReceived }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Work Experience Section -->
      <section class="pds-section">
        <h2>Work Experience</h2>
        <table class="pds-table">
          <thead>
            <tr>
              <th>Address</th>
              <th>Contact Number</th>
              <th>Dates</th>
              <th>Position Title</th>
              <th>Department/Agency</th>
              <th>Monthly Salary</th>
              <th>Salary Grade</th>
              <th>Status</th>
              <th>Government Service (Y/N)</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(work, index) in formData.workExperience" :key="index">
              <td>{{ work.address }}</td>
              <td>{{ work.contactNumber }}</td>
              <td>{{ work.dates }}</td>
              <td>{{ work.positionTitle }}</td>
              <td>{{ work.departmentAgency }}</td>
              <td>{{ work.monthlySalary }}</td>
              <td>{{ work.salaryGrade }}</td>
              <td>{{ work.status }}</td>
              <td>{{ work.govService }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Family Section -->
      <section class="pds-section">
        <h2>Family</h2>
        <table class="pds-table">
          <thead>
            <tr>
              <th>Relation</th>
              <th>Name</th>
              <th>Age</th>
              <th>Occupation</th>
              <th>Contact Number</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(family, index) in formData.family" :key="index">
              <td>{{ family.relation }}</td>
              <td>{{ family.name }}</td>
              <td>{{ family.age }}</td>
              <td>{{ family.occupation }}</td>
              <td>{{ family.contactNumber }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Achievements Section -->
      <section class="pds-section">
        <h2>Achievements</h2>
        <table class="pds-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(achievement, index) in formData.achievements" :key="index">
              <td>{{ achievement.name }}</td>
              <td>{{ achievement.description }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- Action Buttons -->
      <div class="pds-submit">
        <!-- <router-link to="/work">
          <button>Back to Work Section</button>
        </router-link>
        <router-link to="/education">
          <button>Back to Education Section</button>
        </router-link> -->
        <button @click="convertToPDF">Convert to PDF</button>
      </div>
    </div>
  </template>

  <script>
  import jsPDF from 'jspdf';
  import 'jspdf-autotable';

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
          email: '',
          houseNumberStreetSubdivision: '',
          barangay: '',
          cityTown: '',
          province: '',
          country: '',
          zipCode: '',
          contactNumber: '',
          addressType: 'Permanent',
          education: [],
          workExperience: [],
          family: [],
          achievements: []
        }
      };
    },
    mounted() {
      this.fetchFormData();
    },
    methods: {
      fetchFormData() {
        this.formData = {
          surname: 'AQUINO',
          firstname: 'ALDRIN JAY',
          middlename: '?',
          extname: '',
          dob: '2003/17/09',
          placeOfBirth: 'BANGUI, PH',
          sex: 'Male',
          citizenship: 'Filipino',
          dualType: '',
          dualCountry: '',
          height: '175 cm',
          weight: '70 kg',
          bloodType: 'O+',
          civilStatus: 'Single',
          email: 'DRINJAY@GMAIL.COM',
          houseNumberStreetSubdivision: '123 Main St',
          barangay: 'Barangay 1',
          cityTown: 'City',
          province: 'Province',
          country: 'Country',
          zipCode: '12345',
          contactNumber: '123-456-7890',
          addressType: 'Permanent',
          education: [
            {
              level: 'Elementary',
              schoolName: 'Elementary School A',
              schoolAddress: '123 School St, City',
              yearGraduated: '2002',
              degreeCourse: 'Basic Education',
              highestLevelUnits: 'N/A',
              honorsReceived: 'Honor Student'
            },
            {
              level: 'High School',
              schoolName: 'High School B',
              schoolAddress: '456 School Ave, City',
              yearGraduated: '2006',
              degreeCourse: 'Secondary Education',
              highestLevelUnits: 'N/A',
              honorsReceived: 'With Honors'
            },
            {
              level: 'College',
              schoolName: 'MMSU CCIS',
              schoolAddress: '789 University Blvd, City',
              yearGraduated: '2010',
              degreeCourse: 'Bachelor of Science in Computer Science',
              highestLevelUnits: 'N/A',
              honorsReceived: 'Cum Laude'
            }
          ],
          workExperience: [
            {
              address: 'Company A',
              contactNumber: '123-456-7890',
              dates: '2010-2015',
              positionTitle: 'Software Developer',
              departmentAgency: 'IT Department',
              monthlySalary: '$3000',
              salaryGrade: '15',
              status: 'Permanent',
              govService: 'No'
            },
            {
              address: 'Company B',
              contactNumber: '098-765-4321',
              dates: '2016-Present',
              positionTitle: 'Senior Software Engineer',
              departmentAgency: 'IT Department',
              monthlySalary: 'PHP 5000',
              salaryGrade: '20',
              status: 'Permanent',
              govService: 'No'
            }
          ],
          family: [
            {
              relation: 'Father',
              name: 'DADDY NI ALDRIN',
              age: '60',
              occupation: 'Retired',
              contactNumber: '123-456-7890'
            },
            {
              relation: 'MAMA NI ALDRIN',
              name: 'Jane Doe',
              age: '58',
              occupation: 'Homemaker',
              contactNumber: '098-765-4321'
            },
            {
              relation: 'ADING NI ALDRIN',
              name: 'Anna Doe',
              age: '30',
              occupation: 'Teacher',
              contactNumber: '111-222-3333'
            }
          ],
          achievements: [
            {
              name: 'WINNER CHICKEN DINNER',
              description: 'PUGM TOP1 PLACEMENT'
            },
            {
              name: 'BOT LOBBY',
              description: 'TOP 1 IN BOT LOBBY'
            }
          ]
        };
      },
      convertToPDF() {
        const doc = new jsPDF();
        const pageWidth = doc.internal.pageSize.getWidth();
        let y = 10;

        // Add title
        doc.setFontSize(16);
        doc.text('Personal Data Sheet', pageWidth / 2, y, { align: 'center' });
        y += 10;

        // Add Personal Information
        doc.setFontSize(12);
        doc.text('Personal Information', 10, y);
        y += 10;
        const personalInfo = [
          ['Surname', this.formData.surname || 'N/A'],
          ['First Name', this.formData.firstname || 'N/A'],
          ['Middle Name', this.formData.middlename || 'N/A'],
          ['Extension Name', this.formData.extname || 'N/A'],
          ['Date of Birth', this.formData.dob || 'N/A'],
          ['Place of Birth', this.formData.placeOfBirth || 'N/A'],
          ['Sex', this.formData.sex || 'N/A'],
          ['Citizenship', this.formData.citizenship || 'N/A'],
          ['Height', this.formData.height || 'N/A'],
          ['Weight', this.formData.weight || 'N/A'],
          ['Blood Type', this.formData.bloodType || 'N/A'],
          ['Civil Status', this.formData.civilStatus || 'N/A'],
          ['Email', this.formData.email || 'N/A'],
        ];
        doc.autoTable({
          head: [['Field', 'Value']],
          body: personalInfo,
          startY: y,
          theme: 'grid',
          headStyles: { fillColor: [100, 100, 100] }
        });
        y = doc.autoTable.previous.finalY + 10;

        // Add Education
        doc.setFontSize(12);
        doc.text('Education', 10, y);
        y += 10;
        const educationInfo = this.formData.education.map(edu => [
          edu.level, edu.schoolName, edu.schoolAddress, edu.yearGraduated, edu.degreeCourse, edu.highestLevelUnits, edu.honorsReceived
        ]);
        doc.autoTable({
          head: [['Level', 'School Name', 'School Address', 'Year Graduated', 'Degree/Course', 'Highest Level/Units Earned', 'Honors Received']],
          body: educationInfo,
          startY: y,
          theme: 'grid',
          headStyles: { fillColor: [100, 100, 100] }
        });
        y = doc.autoTable.previous.finalY + 10;

        // Add Work Experience
        doc.setFontSize(12);
        doc.text('Work Experience', 10, y);
        y += 10;
        const workInfo = this.formData.workExperience.map(work => [
          work.address, work.contactNumber, work.dates, work.positionTitle, work.departmentAgency, work.monthlySalary, work.salaryGrade, work.status, work.govService
        ]);
        doc.autoTable({
          head: [['Address', 'Contact Number', 'Dates', 'Position Title', 'Department/Agency', 'Monthly Salary', 'Salary Grade', 'Status', 'Government Service (Y/N)']],
          body: workInfo,
          startY: y,
          theme: 'grid',
          headStyles: { fillColor: [100, 100, 100] }
        });
        y = doc.autoTable.previous.finalY + 10;

        // Add Family
        doc.setFontSize(12);
        doc.text('Family', 10, y);
        y += 10;
        const familyInfo = this.formData.family.map(fam => [
          fam.relation, fam.name, fam.age, fam.occupation, fam.contactNumber
        ]);
        doc.autoTable({
          head: [['Relation', 'Name', 'Age', 'Occupation', 'Contact Number']],
          body: familyInfo,
          startY: y,
          theme: 'grid',
          headStyles: { fillColor: [100, 100, 100] }
        });
        y = doc.autoTable.previous.finalY + 10;

        // Add Achievements
        doc.setFontSize(12);
        doc.text('Achievements', 10, y);
        y += 10;
        const achievementsInfo = this.formData.achievements.map(ach => [
          ach.name, ach.description
        ]);
        doc.autoTable({
          head: [['Name', 'Description']],
          body: achievementsInfo,
          startY: y,
          theme: 'grid',
          headStyles: { fillColor: [100, 100, 100] }
        });

        // Save the PDF
        doc.save('PersonalDataSheet.pdf');
      }
    }
  };
  </script>

  <style scoped>
  .pds-container {
    font-family: Arial, sans-serif;
    margin: 20px;
    width: 50%;
    margin-left: 30%;
  }

  .pds-section {
    margin-bottom: 10px;
  }

  .pds-table {
    width: 100%;
    border-collapse: collapse;
  }

  .pds-table th,
  .pds-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  .pds-table th {
    background-color: #f2f2f2;
  }

  .pds-label {
    font-weight: bold;
  }

  .pds-submit {
    margin-top: 20px;
  }

  .pds-submit button {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #0d6018;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
    margin-top: 10px;
    margin-left:100px;
    width: 70%;
    display: block;
  }

  .pds-submit button:hover {
    background-color: #45a049;
  }






  .family-container {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
  }

  .family-table {
    width: 100%;
    border-collapse: collapse;
  }

  .family-table th,
  .family-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  .family-table th {
    background-color: #f2f2f2;
  }

  .family-header {
    font-weight: bold;
  }

  .family-data {
    font-size: 14px;
  }

  </style>
