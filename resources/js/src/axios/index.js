import axios from 'axios';
import store from '../store';

export default async function createApiWithCsrfToken() {
  const csrfToken = store.getters._csrf;

  if (csrfToken) {
    return axios.create({
      baseURL: 'http://parrotpoo.test',
      headers: {
        common: {
          'Authorization': `Bearer ${csrfToken}`
        }
      }
    });
  } else {
    console.error("Le jeton CSRF n'est pas défini");
    return null;
  }
}