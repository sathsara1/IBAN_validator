import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/Login.vue'
import ValidateIBN from '../views/IBN/ValidateIBN.vue'
import ListIBN from '../views/IBN/ListIBN.vue'
import RegisterView from '../views/Register.vue'
import Dashboard from "@/views/Dashboard.vue";
import {useAuthStore} from "@/stores/authStore.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/',
      component: Dashboard,
      children: [
        {
          path: 'validate',
          name: 'validate',
          component: ValidateIBN,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'list',
          name: 'list',
          component: ListIBN,
          meta: {
            requiresAuth: true,
            requiresAdmin: true
          }
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('token');
    if (!token) {
      next('/');
    } else {
      if (to.meta.requiresAdmin && !authStore.isAdmin) {
        next('/'); // Redirect non-admin users to the login page or an unauthorized page
      } else {
        next();
      }
    }
  } else {
    next();
  }
});


export default router
