import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../views/LandingPage.vue';

const routes = [
  {
    path: '/',  // Ruta principal
    name: 'LandingPage',
    component: LandingPage  // El componente que se renderiza para esta ruta
  }
  // En el futuro, puedes agregar más rutas aquí si tienes más vistas
];

// Usamos `createWebHistory()` sin argumentos
const router = createRouter({
  history: createWebHistory(),  // Usamos el historial de navegador
  routes  // Rutas definidas
});

export default router;
