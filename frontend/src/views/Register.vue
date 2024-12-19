<template>
  <div id="app">
    <div class="wrapper">
      <form @submit.prevent="register">
        <h1>Register</h1>
        <div class="input-box">
          <input type="text" placeholder="Name" v-model="params.name" required />
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="email" placeholder="Email" v-model="params.email" required />
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" v-model="params.password" placeholder="Password" required />
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-box">
          <input type="password" v-model="params.password_confirmation" placeholder="Confirm Password" required />
          <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" class="btn">Register</button>
        <div class="login-link">
          <p>Already have an account? <router-link to="/">Login here</router-link></p>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { useAuthStore } from '@/stores/authStore.js';
import { useRouter } from 'vue-router';

const router = useRouter();
const params = ref({ name: '', email: '', password: '', password_confirmation: '' });
const authStore = useAuthStore();

const register = async () => {
  try {
    const response = await authStore.register(params.value);

    if (response.status === 200) {
      Swal.fire({
        title: 'Success!',
        text: 'Registration successful!',
        icon: 'success',
      });
      router.push('/'); // Redirect to login page after successful registration
    } else {
      Swal.fire({
        title: 'Error!',
        text: response.response?.data?.message ||'Registration failed. Please try again.',
        icon: 'error',
      });
    }
  } catch (error) {
    Swal.fire({
      title: 'Error!',
      text: error.response?.data?.message || 'An unexpected error occurred.',
      icon: 'error',
    });
  }
};
</script>

<style>
/* Add your styles here similar to the Login.vue styles */
</style>