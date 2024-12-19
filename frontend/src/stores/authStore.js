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

    async register(data) {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.post(`${baseUrl}/register`, data);
        return response;
      } catch (error) {
        this.error = error.response?.data?.message || 'An error occurred during registration';
        throw error;
      } finally {
        this.loading = false;
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
        delete axios.defaults.headers.common['Authorization'];
      }
    }
  }
});