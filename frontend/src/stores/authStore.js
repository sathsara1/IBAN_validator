import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from "axios"
import {baseUrl} from '@/Constants/index.js';
import Swal from 'sweetalert2'

export const useAuthStore = defineStore('auth-store', {

  // const user = ref(null);
  // const isLoggedIn = ref(false);
  state: () => ({
    users: [],
  }),
  actions: {
    async login(data) {
      try {
        const response = await axios.post(baseUrl+'/login',data)
        this.users = response.data.user;
        localStorage.setItem('token', response.data.data.token);
        return response.status;
      }
      catch (error) {
        Swal.fire({
          title: 'Error!',
          text: error,
          icon: 'error',
        })
      }
    }
  }

})
