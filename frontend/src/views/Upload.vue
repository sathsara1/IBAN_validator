<template>
  <div style="background: white;
    padding: 20px;
    display: inline;
    color: black;
    line-height: 1.5;
    border: 1px solid;">
    <h1>Excel Upload </h1>
    <input type="file" ref="fileInput" multiple accept=".xlsx, .xlsm, .xlsb, .xls" />
    <button class="rounded bg-amber-400 p-2.5" v-if="!uploading" @click="handleUpload" :disabled="uploading">Upload</button>
    <span v-else>Uploading...</span>
    <div v-if="errorMessage || successMessage">{{ errorMessage || successMessage }}</div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';
import { baseUrl } from '@/Constants/index.js'

const router = useRouter()

const fileInput = ref(null);
const uploading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');
const token = computed(() => localStorage.getItem('token') ? localStorage.getItem('token') : null)

const handleUpload = async () => {
  uploading.value = true;

  try {
    const formData = new FormData();
    const files = fileInput.value.files;

    if (!files.length) {
      Swal.fire({
        title: 'Error!',
        text: 'No files selected.',
        icon: 'error',
      })
      return;
    }

    for (const element of files) {
      const file = element

      if (!file.type.startsWith('application/vnd.')) {
        Swal.fire({
          title: 'Error!',
          text: 'Invalid file type. Please select Excel files only.',
          icon: 'error',
        })
        return;
      }

      if (file.size > 10 * 1024 * 1024) { // Limit to 10MB
        Swal.fire({
          title: 'Error!',
          text: 'File size exceeds limit (10MB). Please select smaller files.',
          icon: 'error',
        })
        return;
      }

      formData.append('files[]', file);
    }

    const token = localStorage.getItem('token');

    if (token) {
      const response = await fetch(baseUrl+'/upload', {
        method: 'POST',
        body: formData,
        headers: {
          'Authorization': `Bearer ${token}`,
        },
      });

      const data = await response.json();

      if (data.status === 'success') {
        fileInput.value.value = null;
        Swal.fire({
          title: 'Success',
          text: 'File(s) uploaded successfully!',
          icon: 'success',
        })
      } else {
        Swal.fire({
          title: 'Error!',
          text: data.message,
          icon: 'error',
        })
      }
    }else{
      Swal.fire({
        title: 'Error!',
        text: 'Please login to upload files.',
        icon: 'error',
      })
      router.push('/')
    }

  } catch (error) {
    Swal.fire({
      title: 'Error!',
      text: error,
      icon: 'error',
    })
  } finally {
    uploading.value = false;
  }
};
</script>
<style>
body {
  /* background: unset; */
}
</style>
