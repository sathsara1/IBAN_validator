<template>
  <div class="dashboard-container">
    <div class="sidebar" :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
      <div class="logo-container">
        <h2 class="logo">IBAN Manager</h2>
      </div>
      <nav class="sidebar-nav">
        <router-link
            to="/validate"
            class="nav-link"
            :class="{ active: $route.path === '/validate' }"
        >
          <i class="fas fa-check-circle"></i>
          <span>Verify IBAN</span>
        </router-link>
        <router-link
            to="/list"
            class="nav-link"
            :class="{ active: $route.path === '/list' }"
            v-if="authStore.isAdmin"
        >
          <i class="fas fa-list"></i>
          <span>IBAN List</span>
        </router-link>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Top Navigation Bar -->
      <div class="top-nav">
        <button class="toggle-sidebar" @click="toggleSidebar">
          <i class="fas fa-bars"></i>
        </button>
        <div class="user-menu">
          <span class="user-name">{{ authStore.user?.name }}</span>
          <button class="logout-btn" @click="handleLogout">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </div>
      </div>

      <!-- Page Content -->
      <div class="content">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import {useAuthStore} from "@/stores/authStore.js";


const router = useRouter();
const authStore = useAuthStore();
const isSidebarCollapsed = ref(false);
console.log(authStore.isAdmin);
const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const handleLogout = async () => {
  await authStore.logout();
  router.push('/');
};
</script>

<style scoped>
.dashboard-container {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: white;
  transition: width 0.3s;
}

.sidebar-collapsed {
  width: 80px;
}

.logo-container {
  padding: 20px;
  text-align: center;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo {
  color: white;
  margin: 0;
  font-size: 1.5rem;
}

.sidebar-nav {
  padding: 20px 0;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 12px 20px;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s;
}

.nav-link:hover,
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link i {
  margin-right: 10px;
  width: 20px;
  text-align: center;
}

.main-content {
  flex: 1;
  background-color: #f5f6fa;
}

.top-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.toggle-sidebar {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #2c3e50;
}

.user-menu {
  display: flex;
  align-items: center;
  gap: 15px;
}

.user-name {
  font-weight: 500;
}

.logout-btn {
  padding: 8px 16px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.logout-btn:hover {
  background-color: #c0392b;
}

.content {
  padding: 30px;
}

@media (max-width: 768px) {
  .sidebar {
    position: fixed;
    height: 100vh;
    z-index: 1000;
    transform: translateX(0);
    transition: transform 0.3s;
  }

  .sidebar-collapsed {
    transform: translateX(-250px);
  }

  .main-content {
    margin-left: 0;
  }
}
</style>