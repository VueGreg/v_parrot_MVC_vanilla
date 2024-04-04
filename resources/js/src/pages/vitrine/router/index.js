import { createRouter, createWebHistory } from 'vue-router';
import Acceuil from '../pages/acceuil.vue';
import Reparations from '../pages/reparations.vue';
import Vehicules from '../pages/vehicules.vue';

const routes = [
  {
    path: '/',
    name: 'acceuil',
    component: Acceuil
  },
  {
    path: '/reparations',
    name: 'reparations',
    component: Reparations
  },
  {
    path: '/vehicules',
    name: 'vehicules',
    component: Vehicules
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

const savedScrollPositions = {};
  
const saveScrollPosition = (path) => {
  savedScrollPositions[path] = {
    x: window.pageXOffset,
    y: window.pageYOffset
  };
};

const restoreScrollPosition = (path) => {
  const savedPosition = savedScrollPositions[path];
  if (savedPosition) {
    window.scrollTo(savedPosition.x, savedPosition.y);
  } else {
    window.scrollTo(0, 0);
  }
};

router.beforeEach((to, from) => {
  if (from && from.path) {
    saveScrollPosition(from.path);
  }
});

router.afterEach((to, from) => {
  restoreScrollPosition(to.path);
});

export default router;