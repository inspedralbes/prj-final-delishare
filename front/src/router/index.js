import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../views/LandingPage.vue';
import SearchPage from '../views/SearchPage.vue';
import Login from "../components/login.vue";
import Register from '../components/register.vue';
import SavedPage from '../views/SavedPage.vue'; // Importamos el nuevo componente

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
    component: Register,  // El componente que se renderiza para el registro
  },
  {
    path: '/saved',  // Nueva ruta de recetas guardadas
    name: 'SavedPage',
    component: SavedPage,  // El componente que se renderiza para las recetas guardadas
  },
];

const router = createRouter({
  history: createWebHistory(),  // Usamos el historial de navegador
  routes,  // Rutas definidas
});

export default router;
