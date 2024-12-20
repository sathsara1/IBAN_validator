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
          <span :class="{ 'hidden': isSidebarCollapsed }">Verify IBAN</span>
        </router-link>
        <router-link
            to="/list"
            class="nav-link"
            :class="{ active: $route.path === '/list' }"
            v-if="isAdmin()"
        >
          <i class="fas fa-list"></i>
          <span :class="{ 'hidden': isSidebarCollapsed }">IBAN List</span>
        </router-link>
      </nav>
    </div>

    <div class="main-content" :class="{ 'content-expanded': isSidebarCollapsed }">
      <div class="top-nav">
        <button class="toggle-sidebar" @click="toggleSidebar">
          <i class="fas fa-bars"></i>
        </button>
        <div class="user-menu">
          <span class="user-name">Welcome {{ userName() }}</span>
          <button class="logout-btn" @click="handleLogout">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </div>
      </div>

      <div class="content">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import {useRouter} from 'vue-router';
import {useAuthStore} from "@/stores/authStore.js";

const router = useRouter();
const authStore = useAuthStore();
const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const handleLogout = async () => {
  await authStore.logout();
  router.push('/');
};

const isAdmin = () => {
 return localStorage.getItem('role') === 'admin';
}

const userName = () => {
  return localStorage.getItem('name');
}

</script>

<style scoped>
.dashboard-container {
  display: flex;
  min-height: 100vh;
  max-height: 100vh;
  overflow: hidden;
}

.sidebar {
  width: 250px;
  background-color: #2c3e50;
  color: white;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar-collapsed {
  width: 70px;
}

.sidebar-collapsed .logo {
  font-size: 1.2rem;
}

.logo-container {
  padding: 1.5rem 1rem;
  text-align: center;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  background-color: #243442;
}

.logo {
  color: white;
  margin: 0;
  font-size: 1.5rem;
  transition: font-size 0.3s ease;
}

.sidebar-nav {
  padding: 1rem 0;
  flex-grow: 1;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 0.875rem 1.5rem;
  color: #a8b6c3;
  text-decoration: none;
  transition: all 0.3s ease;
  margin: 0.25rem 0.75rem;
  border-radius: 0.5rem;
}

.nav-link:hover,
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
}

.nav-link i {
  min-width: 1.5rem;
  text-align: center;
  font-size: 1.1rem;
  margin-right: 1rem;
}

.sidebar-collapsed .nav-link {
  padding: 0.875rem;
  justify-content: center;
}

.sidebar-collapsed .nav-link i {
  margin-right: 0;
}

.main-content {
  flex: 1;
  background-color: #f5f6fa;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  max-height: 100vh;
}

.content-expanded {
  margin-left: 0;
}

.top-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  height: 4rem;
  flex-shrink: 0;
}

.toggle-sidebar {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #2c3e50;
  padding: 0.5rem;
  border-radius: 0.375rem;
  transition: background-color 0.2s ease;
}

.toggle-sidebar:hover {
  background-color: #f5f6fa;
}

.user-menu {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.user-name {
  font-weight: 1000;
  color: #2c3e50;
}

.logout-btn {
  padding: 0.5rem 1rem;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: background-color 0.2s ease;
  font-weight: 500;
}

.logout-btn:hover {
  background-color: #c0392b;
}

.content {
  padding: 2rem;
  flex-grow: 1;
  overflow-y: auto;
}

.hidden {
  display: none;
}

@media (max-width: 768px) {
  .sidebar {
    position: fixed;
    height: 100vh;
    z-index: 1000;
    transform: translateX(0);
  }

  .sidebar-collapsed {
    transform: translateX(-100%);
  }

  .content {
    padding: 1rem;
  }

  .top-nav {
    padding: 1rem;
  }

  .user-name {
    display: none;
  }
}
</style>