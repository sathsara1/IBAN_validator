<template>
  <div class="list-iban" style="background: white; padding: 20px; color: #0e0e0e; line-height: 1.5; border: 1px solid;">
    <h1>List of IBANs</h1>

    <!-- Search Box -->
    <div class="search-box">
      <input
          type="text"
          v-model="ibanStore.searchQuery"
          placeholder="Search by IBAN, name, or email..."
          class="search-input"
      >
    </div>

    <div v-if="ibanStore.loading">Loading...</div>
    <div v-if="ibanStore.error" class="error">{{ ibanStore.error }}</div>

    <table v-if="ibanStore.paginatedIbans.length > 0">
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

    <!-- Pagination -->
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

    <div v-else-if="!ibanStore.loading">No IBANs found.</div>
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
.list-iban {
  max-width: 1000px;
  margin: auto;
}

.error {
  color: red;
  margin: 10px 0;
}

.search-box {
  margin: 20px 0;
}

.search-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: white;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f8f9fa;
  font-weight: 600;
}

tr:hover {
  background-color: #f5f5f5;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  gap: 10px;
}

.pagination-btn {
  padding: 8px 16px;
  border: 1px solid #ddd;
  background-color: white;
  cursor: pointer;
  border-radius: 4px;
}

.pagination-btn:disabled {
  background-color: #f5f5f5;
  cursor: not-allowed;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #f0f0f0;
}

.page-info {
  margin: 0 10px;
}

/* Responsive table */
@media screen and (max-width: 768px) {
  table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
}
</style>