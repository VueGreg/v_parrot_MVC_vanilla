// https://vitejs.dev/config/#build-polyfillmodulepreload
import 'vite/modulepreload-polyfill'

// Bootstrap
import "bootstrap/dist/css/bootstrap.css";
import 'bootstrap/dist/js/bootstrap.bundle';

// Vue
import { createApp } from 'vue';
import store from './store';

const data = JSON.parse(document.getElementById('vue-app').getAttribute('data-php-data'));
const Page = import(`./pages/${filename}.vue`).then(module => module.default);

Promise.all([Page]).then(([Page]) => {
  if (filename === 'vitrine/vitrine') {
    store.dispatch('saveLayoutData', data);
  }

  if (hasRouter == 1) {
    import('./pages/vitrine/router').then(routerModule => {
      const router = routerModule.default;
      createApp(Page, { data }).use(router).use(store).mount('#app');
    }).catch(error => {
      console.error('Erreur lors de l\'importation du routeur :', error);
    });
  } else {
    createApp(Page, { data }).use(store).mount('#app');
  }
}).catch(error => {
  console.error('Une erreur est survenue lors du chargement de la page :', error);
});