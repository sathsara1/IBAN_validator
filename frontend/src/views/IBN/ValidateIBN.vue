<template>
  <div style="background: white; padding: 20px; display: inline; color: black; line-height: 1.5; border: 1px solid;">
    <h1>Validate IBAN</h1>
    <input type="text" v-model="iban" placeholder="IBAN" />
    <button class="rounded bg-amber-400 p-2.5" v-if="!ibanStore.loading" @click="handleValidate" :disabled="ibanStore.loading">Validate</button>
    <span v-else>Validating...</span>
    <div v-if="ibanStore.error || ibanStore.successMessage">{{ ibanStore.error || ibanStore.successMessage }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import {useIbanStore} from "@/stores/ibansStore.js";

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
body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-size: cover;
  background-color: #f3f4f6;
}
</style>