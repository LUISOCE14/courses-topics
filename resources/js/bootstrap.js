import axios from 'axios';
window.axios = axios;

// Esto es lo clave:
if (document.querySelector('meta[name="csrf-token"]')) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
