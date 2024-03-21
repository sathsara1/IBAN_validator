<template>
  <div id="app">
    <div class="wrapper">
      <form @submit.prevent="login">
        <h1>Login</h1>
        <div class="input-box">
          <input type="text" placeholder="Email" v-model="params.email" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="password" v-model="params.password" id="password" placeholder="password" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" class="btn">Login</button>

      </form>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';
import { useAuthStore } from '@/stores/authStore.js';
import { useRouter } from 'vue-router';
const router = useRouter();

const email = ref('')
const hidePassword = ref(true)
const password = ref('')
const  params = {}

const authStore = useAuthStore()


const login = async () => {
  try {
    await authStore.login(params).then((response) => {
      if (response === 200) {

        router.push('/upload')
      }
      else{
        Swal.fire({
          title: 'Error!',
          text: 'Invalid credentials',
          icon: 'error',
        })
      }
    })

  } catch (e) {
    Swal.fire({
      title: 'Error!',
      text: e,
      icon: 'error',
    })
  }

}
</script>
<style>

*
{
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;

}
body{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background:url(https://cdn.eduonix.com/assets/images/header_img/2019022215330111057.jpg);
  background-size: cover;
  background-position: center;
}
.wrapper {
  /* width: 420px; */
  background: transparent;
  border:2px solid rgba(255, 255, 255, .2);
  backdrop-filter:blur(20px);
  box-shadow: 0 0 10px rgba(0 , 0 , 0 , .2);
  color: #fff;
  border-radius: 10px;
  padding: 30px 40px;

}
.wrapper h1{
  font-size: 36px;
  text-align: center;
}
.wrapper .input-box {
  position: relative;
  width: 100%;
  height: 50px;
  margin: 30px 0;
}

.input-box input{
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, .2);
  border-radius: 40px;
  font-size: 16px;
  color: #fff;
  padding: 20px 45px 20px 20px;
}
.input-box input::placeholder{
  color: #fff;
}
.input-box i{
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;

}
.wrapper .remember-forgot{
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}
.remember-forgot label input{
  accent-color: #fff;
  margin-right: 3px;
}
.remember-forgot a{
  color: #fff;
  text-decoration: none;

}
.remember-forgot a:hover{
  text-decoration: underline;
}
.wrapper .btn{
  width: 100%;
  height: 45px;
  border-radius: 40px;
  border: none;
  outline: none;
  background: #fff;
  box-shadow: 0 0 10px rgba(0 , 0 , 0 , .1);
  cursor: pointer;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}
.wrapper .register-link{
  text-align: center;
  font-size: 14.5px;
  margin:20px 0 15px;
}
.register-link p a{
  color: #fff;
  text-decoration: none;
  font-weight: 600;

}
.register-link p a:hover{
  text-decoration: underline;
}
</style>
