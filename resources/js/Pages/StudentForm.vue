<template>
    <div>
    <h2 align="center">Add New Student</h2>
      <br>
      <table class="table">
        <tr>
          <td>Name:</td>
          <td><input type="text" v-model="formData.name" class="form-control" placeholder="Name"></td>
        </tr>
        <br/>
        <tr>
          <td>Age:</td>
          <td><input type="number" v-model="formData.age" class="form-control" placeholder="Age"></td>
        </tr>
        <br/>
        <tr>
          <td>Image:</td>
          <td><input type="file" @change="onFileChange" class="form-control-file" placeholder="Image"></td>
        </tr>
        <br/>
        <tr>
          <td>Status:</td>
          <td>
            <select v-model="formData.status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </td>
        </tr>
        <br/>
      </table>
      <div class="btn-group mt-3">
        <button type="button" class="btn btn-primary mr-2" @click="submitForm">Submit</button>
        <button type="button" class="btn btn-secondary" @click="goBack">Cancel</button>
      </div>
      <div v-if="error" class="alert alert-danger mt-3" role="alert">
        {{ error }}
      </div>
    </div>
  </template>
  
  
  <script>
  import axios from 'axios';
  import "bootstrap/dist/css/bootstrap.min.css";
  
  export default {
    data() {
      return {
        formData: {
          name: '',
          age: null,
          image: null,
          status: 'active'
        },
        error: ''
      };
    },
    methods: {
      submitForm() {
        let formData = new FormData();
        formData.append('name', this.formData.name);
        formData.append('age', this.formData.age);
        formData.append('image', this.formData.image);
        formData.append('status', this.formData.status);
  
        axios.post('/students', formData)
          .then(() => {
            this.formData = {
              name: '',
              age: null,
              image: null,
              status: 'active'
            };
            alert('Successfully added!');
          })
          .catch(error => {
            console.error('Error:', error.response);
            if (error.response && error.response.data && error.response.data.message) {
              this.error = error.response.data.message;
            } else {
              this.error = 'An error occurred while adding the student.';
            }
          });
      },
      goBack() {
        window.history.back();
      },
      onFileChange(event) {
        this.formData.image = event.target.files[0];
      }
    }
  }
  </script>
  