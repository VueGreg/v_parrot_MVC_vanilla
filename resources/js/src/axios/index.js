import axios from 'axios';
import store from '../store';

const csrfToken = store.getters._csrf;

let api;

if (csrfToken) {
  api = axios.create({
    baseURL: 'http://parrotpoo.test',
    headers: {
      common: {
        'Authorization': `Bearer ${csrfToken}`
      }
    }
  });
} else {
  console.error("Le jeton CSRF n'est pas défini");
}

export default api;