<template>
  <div class="validate-iban-container">
    <div class="validate-iban-content">
      <h2 class="title">Validate IBAN</h2>

      <div class="input-group">
        <input
            type="text"
            v-model="iban"
            placeholder="Enter IBAN number"
            class="iban-input"
        />

        <button
            class="validate-btn"
            v-if="!ibanStore.loading"
            @click="handleValidate"
            :disabled="ibanStore.loading"
        >
          Validate
        </button>

        <div v-else class="loading">
          Validating...
        </div>
      </div>

      <div
          v-if="ibanStore.error || ibanStore.successMessage"
          class="message"
          :class="{ 'error': ibanStore.error, 'success': ibanStore.successMessage }"
      >
        {{ ibanStore.error || ibanStore.successMessage }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { useIbanStore } from "@/stores/ibansStore.js";

const ibanStore = useIbanStore();
const iban = ref('');

const handleValidate = async () => {
  if (!iban.value) {
    Swal.fire('Error!', 'IBAN is required.', 'error');
    return;
  }

  await ibanStore.validateIbn(iban.value);

  if (ibanStore.error) {
    Swal.fire('Error!', ibanStore.error, 'error');
  } else if (ibanStore.successMessage) {
    Swal.fire('Success!', 'IBAN is valid.', 'success');
  }
  iban.value = '';
};
</script>

<style scoped>
.validate-iban-container {
  height: 100%;
  background-color: #f8f9fa;
  padding: 2rem;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

.validate-iban-content {
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  width: 100%;
  max-width: 600px;
}

.title {
  color: #2c3e50;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

.input-group {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.iban-input {
  color: #0a0a0a;
  flex: 1;
  padding: 0.75rem 1rem;
  border: 1px solid #e9ecef;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  transition: border-color 0.15s ease-in-out;
}

.iban-input:focus {
  outline: none;
  border-color: #4a90e2;
  box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
}

.validate-btn {
  padding: 0.75rem 1.5rem;
  background-color: #fbbf24;
  color: #000;
  border: none;
  border-radius: 0.375rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.15s ease-in-out;
}

.validate-btn:hover {
  background-color: #f59e0b;
}

.validate-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.loading {
  color: #6c757d;
  padding: 0.75rem 0;
}

.message {
  padding: 1rem;
  border-radius: 0.375rem;
  margin-top: 1rem;
}

.message.error {
  background-color: #fee2e2;
  color: #dc2626;
  border: 1px solid #fecaca;
}

.message.success {
  background-color: #d1fae5;
  color: #059669;
  border: 1px solid #a7f3d0;
}

@media screen and (max-width: 768px) {
  .validate-iban-container {
    padding: 1rem;
  }

  .input-group {
    flex-direction: column;
  }

  .validate-btn {
    width: 100%;
  }
}
</style>