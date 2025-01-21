import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../views/LandingPage.vue';
import SearchPage from '../views/SearchPage.vue';

const routes = [
  {
    path: '/',  // Ruta principal
    name: 'LandingPage',
    component: LandingPage,  // El componente que se renderiza para esta ruta
  },
  {
    path: '/search',  // Ruta de búsqueda
    name: 'SearchPage',
    component: SearchPage,  // El componente que se renderiza para la búsqueda
  },
];

const router = createRouter({
  history: createWebHistory(),  // Usamos el historial de navegador
  routes,  // Rutas definidas
});

export default router;
