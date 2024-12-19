<template>
  <div class="list-iban-container">
    <div class="list-iban-content">
      <div class="header-section">
        <h1 class="text-2xl font-bold text-gray-800">List of IBANs</h1>
        <div class="search-box">
          <input
              type="text"
              v-model="ibanStore.searchQuery"
              placeholder="Search by IBAN, name, or email..."
              class="search-input"
          >
        </div>
      </div>

      <div v-if="ibanStore.loading" class="loading-state">
        <span class="loading-text">Loading...</span>
      </div>

      <div v-if="ibanStore.error" class="error-message">{{ ibanStore.error }}</div>

      <div class="table-container" v-if="ibanStore.paginatedIbans.length > 0">
        <table>
          <thead>
          <tr>
            <th>ID</th>
            <th>IBAN</th>
            <th>User Name</th>
            <th>Email</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="iban in ibanStore.paginatedIbans" :key="iban.id">
            <td>{{ iban.id }}</td>
            <td>{{ iban.iban }}</td>
            <td>{{ iban.verified_by.name }}</td>
            <td>{{ iban.verified_by.email }}</td>
          </tr>
          </tbody>
        </table>
      </div>

      <div v-if="ibanStore.paginatedIbans.length > 0" class="pagination">
        <button
            :disabled="ibanStore.currentPage === 1"
            @click="ibanStore.currentPage--"
            class="pagination-btn"
        >
          Previous
        </button>
        <span class="page-info">
          Page {{ ibanStore.currentPage }} of {{ ibanStore.totalPages }}
        </span>
        <button
            :disabled="ibanStore.currentPage === ibanStore.totalPages"
            @click="ibanStore.currentPage++"
            class="pagination-btn"
        >
          Next
        </button>
      </div>

      <div v-else-if="!ibanStore.loading" class="no-data">
        No IBANs found.
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useIbanStore } from "@/stores/ibansStore.js";

const ibanStore = useIbanStore();

onMounted(() => {
  ibanStore.fetchIbans();
});
</script>

<style scoped>
.list-iban-container {
  height: 100%;
  background-color: #f8f9fa;
  padding: 2rem;
}

.list-iban-content {
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  height: 100%;
  display: flex;
  flex-direction: column;
}

.header-section {
  padding: 1.5rem;
  border-bottom: 1px solid #e9ecef;
}

.search-box {
  margin-top: 1rem;
}

.search-input {
  color: #0a0a0a;
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e9ecef;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  transition: border-color 0.15s ease-in-out;
}

.search-input:focus {
  outline: none;
  border-color: #4a90e2;
  box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
}

.table-container {
  flex: 1;
  overflow-x: auto;
  padding: 1rem;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

th, td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #e9ecef;
}

th {
  background-color: #f8f9fa;
  font-weight: 600;
  color: #0a0a0a;
}

tr:hover {
  color: #3838da;
  background-color: #f8f9fa;
}

tr{
  color: #0a0a0a;
}

.pagination {
  color: #0a0a0a;
  padding: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  border-top: 1px solid #e9ecef;
}

.pagination-btn {
  color: #0a0a0a;
  padding: 0.5rem 1rem;
  border: 1px solid #e9ecef;
  background-color: white;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.15s ease-in-out;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.pagination-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.loading-state, .error-message, .no-data {
  padding: 2rem;
  text-align: center;
  color: #6c757d;
}

.error-message {
  color: #dc3545;
}

@media screen and (max-width: 768px) {
  .list-iban-container {
    padding: 1rem;
  }

  th, td {
    padding: 0.75rem;
  }
}
</style>
