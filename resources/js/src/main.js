// https://vitejs.dev/config/#build-polyfillmodulepreload
import 'vite/modulepreload-polyfill'

// Bootstrap
import "bootstrap/dist/css/bootstrap.css";
import 'bootstrap/dist/js/bootstrap.bundle';

// Vue
import { createApp } from 'vue'

const data = JSON.parse(document.getElementById('vue-app').getAttribute('data-php-data'));
const Page = import(`./pages/${filename}.vue`).then(module => module.default);

Promise.all([Page]).then(([Page]) => {
  createApp(Page, { data }).mount('#app');
}).catch(error => {
  console.error('Une erreur est survenue lors du chargement de la page :', error);
});