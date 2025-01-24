import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../views/LandingPage.vue';
import SearchPage from '../views/SearchPage.vue';
import Login from "../components/login.vue";
import register from '../components/register.vue';

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
  {
    path: '/login',  // Ruta de login
    name: 'LoginPage',
    component: Login,  // El componente que se renderiza para el login
  },
  {
    path: '/register',  // Ruta de registro
    name: 'RegisterPage',
    component: register ,  // El componente que se renderiza para el registro
  }

];

const router = createRouter({
  history: createWebHistory(),  // Usamos el historial de navegador
  routes,  // Rutas definidas
});

export default router;
