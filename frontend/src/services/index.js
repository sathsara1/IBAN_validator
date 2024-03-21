import axios from 'axios';
import {baseUrl} from '@/Constants/index.js';

export const API = axios.create({
    baseURL: baseUrl,
    headers: {
        'Content-Type': 'application/vnd.api+json',
        'Accept': 'application/vnd.api+json',
    },
});
