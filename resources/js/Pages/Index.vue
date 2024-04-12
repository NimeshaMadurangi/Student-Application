<template>
    <div>
      <h2 align="center">Student List</h2>
      <br>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.id">
            <td>{{ student.name }}</td>
            <td>{{ student.age }}</td>
            <td>
              <img :src="'/images/' + student.image" style="max-width: 100px; max-height: 100px;">
            </td>
            <td>{{ student.status }}</td>
            <td>
              <button @click="editStudent(student)" class="btn btn-primary">Edit</button>
              <button @click="deleteStudent(student.id)" class="btn btn-danger" style="margin-left: 5px;">Delete</button>
              <button @click="toggleStatus(student)" :class="{'btn btn-warning': student.status === 'active', 'btn btn-success': student.status === 'inactive'}" style="margin-left: 5px;">
                {{ student.status === 'active' ? 'Inactive' : 'Active' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <EditStudentForm v-if="showEditForm" :student="selectedStudent" @update="updateStudent" @cancel="cancelEdit"/>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import "bootstrap/dist/css/bootstrap.min.css";
  import EditStudentForm from './EditStudentForm.vue';
  
  export default {
    data() {
      return {
        students: [],
        selectedStudent: null,
        showEditForm: false
      };
    },
    created() {
      this.fetchStudents();
    },
    methods: {
      fetchStudents() {
        axios.get('/students')
          .then(response => {
            this.students = response.data;
          })
          .catch(error => {
            console.error('Error fetching students:', error);
          });
      },
      editStudent(student) {
        this.selectedStudent = student;
        this.showEditForm = true;
      },
      deleteStudent(studentId) {
        axios.delete(`/students/${studentId}`)
          .then(response => {
            console.log(response.data.message);
            this.students = this.students.filter(student => student.id !== studentId);
          })
          .catch(error => {
            console.error('Error deleting student:', error);
          });
      },
      toggleStatus(student) {
        student.status = student.status === 'active' ? 'inactive' : 'active';
        axios.put(`/students/${student.id}`, { status: student.status })
          .then(response => {
            console.log(response.data.message);
          })
          .catch(error => {
            console.error('Error updating student status:', error);
          });
      },
      updateStudent(updatedStudent) {
        axios.put(`/students/${updatedStudent.id}`, updatedStudent)
          .then(response => {
            console.log(response.data.message);
            const index = this.students.findIndex(s => s.id === updatedStudent.id);
            if (index !== -1) {
              this.students[index] = updatedStudent;
            }
            this.showEditForm = false;
          })
          .catch(error => {
            console.error('Error updating student:', error);
          });
      },
      cancelEdit() {
        this.showEditForm = false;
      }
    },
    components: {
      EditStudentForm
    }
  }
  </script>
  