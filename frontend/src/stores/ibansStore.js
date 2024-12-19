import {defineStore} from 'pinia';
import {computed, ref} from 'vue';
import {baseUrl} from '@/Constants/index.js';
import {useAuthStore} from "@/stores/authStore.js";

export const useIbanStore = defineStore('iban', () => {
    const ibans = ref([]);
    const loading = ref(false);
    const error = ref('');
    const successMessage = ref('');
    const searchQuery = ref('');
    const currentPage = ref(1);
    const itemsPerPage = ref(7);
    const authStore = useAuthStore();

    const filteredIbans = computed(() => {
        if (!searchQuery.value) return ibans.value;

        return ibans.value.filter(iban =>
            iban.iban.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            iban.verified_by.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            iban.verified_by.email.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });

    const paginatedIbans = computed(() => {
        const startIndex = (currentPage.value - 1) * itemsPerPage.value;
        const endIndex = startIndex + itemsPerPage.value;
        return filteredIbans.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() =>
        Math.ceil(filteredIbans.value.length / itemsPerPage.value)
    );

    const fetchIbans = async () => {
        loading.value = true;
        error.value = '';
        successMessage.value = '';

        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Please login to view IBANs.');
            }
            if (!authStore.isAdmin) {
                    throw new Error('You do not have permission to view IBANs.');
            }
            const response = await fetch(`${baseUrl}/ibans`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.status === 200) {
                ibans.value = data.data;
                currentPage.value = 1;
            } else {
                throw new Error(data.message || 'Failed to fetch IBANs');
            }
        } catch (err) {
            error.value = err.message || 'Failed to fetch IBANs. Please try again later.';
        } finally {
            loading.value = false;
        }
    };

    const validateIbn = async (iban) => {
        loading.value = true;
        error.value = '';
        successMessage.value = '';

        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Please login to validate IBAN.');
            }

            const response = await fetch(`${baseUrl}/verify`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({iban}),
            });

            const data = await response.json();

            if (data.status === 201) {
                successMessage.value = 'IBAN validated successfully!';
            } else {
                error.value = data.message;
            }
        } catch (err) {
            error.value = err.message || 'Failed to validate IBAN. Please try again later.';
        } finally {
            loading.value = false;
        }
    };

    return {
        ibans,
        loading,
        error,
        successMessage,
        searchQuery,
        currentPage,
        itemsPerPage,
        paginatedIbans,
        totalPages,
        fetchIbans,
        validateIbn
    };
});