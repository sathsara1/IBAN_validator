import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/Login.vue'
import UploadView from '../views/Upload.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/upload',
      name: 'upload',
      component: UploadView,
      meta: {
        requiresAuth: true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('token');
    if (token) {
      next();
    } else {
      next('/');
    }
  } else {  
    next();
  }
});

export default router
