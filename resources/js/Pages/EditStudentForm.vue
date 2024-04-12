<template>
    <div>
      <h2>Edit Student</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" v-model="editedStudent.name" class="form-control" id="name">
        </div>
        <div class="form-group">
          <label for="age">Age:</label>
          <input type="number" v-model="editedStudent.age" class="form-control" id="age">
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select v-model="editedStudent.status" class="form-control" id="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" @click="cancelEdit" class="btn btn-secondary">Cancel</button>
      </form>
      <div v-if="successMessage" class="alert alert-success" role="alert">
        {{ successMessage }}
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import "bootstrap/dist/css/bootstrap.min.css";
  
  export default {
    props: {
      student: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        editedStudent: { ...this.student },
        successMessage: ''
      };
    },
    methods: {
      submitForm() {
        axios.put(`/students/${this.editedStudent.id}`, this.editedStudent)
          .then(response => {
            console.log(response.data.message);
            this.successMessage = response.data.message;
            this.$emit('update', this.editedStudent);
          })
          .catch(error => {
            console.error('Error updating student:', error);
          });
      },
      cancelEdit() {
        this.$emit('cancel');
      }
    }
  };
  </script>
  