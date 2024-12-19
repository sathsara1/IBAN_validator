<template>
  <div id="login">
    <div class="wrapper">
      <form @submit.prevent="login">
        <h1>Login</h1>
        <div class="input-box">
          <input type="text" placeholder="Email" v-model="params.email" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="password" v-model="params.password" id="password" placeholder="Password" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" class="btn">Login</button>
        <div class="register-link">
          <p>Don't have an account?
            <router-link to="/register">Register here</router-link>
          </p>
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
const params = ref({ email: '', password: '' });
const authStore = useAuthStore();

const login = async () => {
  try {
    const response = await authStore.login(params.value);
    if (response.status === 200) {
      router.push('/validate');
    } else {
      Swal.fire({
        title: 'Error!',
        text: response.response?.data?.message || 'Invalid credentials',
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
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  min-height: 100vh;
  background: linear-gradient(135deg, #1f2937, #4b5563);
  margin: 0;
  color: #fff;
}

#login {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.wrapper {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  padding: 20px;
  border-radius: 10px;
  width: 90%;
  max-width: 400px;
}

.wrapper h1 {
  font-size: 1.8rem;
  margin-bottom: 15px;
}

.input-box {
  position: relative;
  width: 100%;
  margin-bottom: 12px;
}

.input-box input {
  width: 100%;
  padding: 8px 15px;
  border: none;
  border-radius: 25px;
  outline: none;
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  font-size: 14px;
}

.input-box input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.input-box i {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  color: rgba(255, 255, 255, 0.7);
  font-size: 16px;
}

.btn {
  width: 100%;
  padding: 8px 0;
  border: none;
  border-radius: 25px;
  background: #4caf50;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s;
}

.btn:hover {
  background: #45a049;
}

.register-link {
  margin-top: 8px;
}

.register-link p {
  font-size: 13px;
}

.register-link a {
  color: #4caf50;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}
</style>