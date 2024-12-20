import { defineStore } from 'pinia'
import axios from "axios"
import {baseUrl} from '@/Constants/index.js';

export const useAuthStore = defineStore('auth-store', {
  state: () => ({
    user: null,
    isAuthenticated: false,
    token: localStorage.getItem('token') || null,
    error: null,
    loading: false
  }),

  getters: {

    isAdmin: (state) => state.user?.role === 'admin',
    getUser: (state) => state.user,
  },

  actions: {
    async login(data) {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.post(baseUrl + '/login', data)
        if (response.data.data.token) {
          this.token = response.data.data.token;
          localStorage.setItem('token', this.token);
          localStorage.setItem('role', response.data.data.user.role);
          localStorage.setItem('name', response.data.data.user.name);


          this.user = response.data.data.user;
          this.isAuthenticated = true;

          axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
          return response;
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'An error occurred during login';
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async fetchAuthenticatedUser() {
      if (!this.token) return;

      try {
        const response = await axios.get(`${baseUrl}/me`, {
          headers: {
            'Authorization': `Bearer ${this.token}`
          }
        });

        if (response.status === 200) {
          this.user = response.data;
          this.isAuthenticated = true;
          axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        }
      } catch (error) {
        console.error('Failed to fetch user', error);
        this.logout(); // Logout if the token is invalid
      }
    },

    async logout() {
      try {
        if (this.token) {
          await axios.post(`${baseUrl}/logout`, {}, {
            headers: {Authorization: `Bearer ${this.token}`}
          });
        }
      } catch (error) {
        console.error('Logout error:', error);
      } finally {
        this.user = null;
        this.token = null;
        this.isAuthenticated = false;
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        localStorage.removeItem('name');
        delete axios.defaults.headers.common['Authorization'];
      }
    },

    persist: {
      enabled: true,
    },
  }
});
