import { createRouter, createWebHistory } from 'vue-router';
import Login from "@/components/login.vue";
import register from '@/components/register.vue';
import Profile from '@/components/profile.vue';
import { useAuthStore } from "@/stores/useAuthStore";
import RecipesTable from '@/components/RecipesTable.vue'; // Ajusta si el archivo tiene otro nombre o ruta
import LandingPage from '@/views/LandingPage.vue';
import SearchPage from '@/views/SearchPage.vue';
const routes = [
  {
    path: '/recipes',
    name: 'RecipesTable',
    component: RecipesTable,
  },
  {
    path: '/',  // Ruta principal
    name: 'LandingPage',
    component: LandingPage,  // El componente que se renderiza para esta ruta
    meta: { requiresAuth: true },

  },
  {
    path: '/search',  // Ruta de búsqueda
    name: 'SearchPage',
    component: SearchPage,  // El componente que se renderiza para la búsqueda
    meta: { requiresAuth: true },

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
  },
  {
    path: '/profile',  // Ruta de perfil
    name: 'ProfilePage',
    component: Profile,  // El componente que se renderiza para el perfil
    meta: { requiresAuth: true },
  }

  
];

const router = createRouter({
  history: createWebHistory(), // Usa el historial del navegador para manejar rutas
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && !authStore.isLoggedIn()) {
      // Si la ruta requiere autenticación y el usuario no está logueado, redirige al login
      return next({ name: "LoginPage" });
  }

  next(); // Permite la navegación si no hay restricciones
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && !authStore.isLoggedIn()) {
      // Si la ruta requiere autenticación y el usuario no está logueado, redirige al login
      return next({ name: "LoginPage" });
  }

  next(); // Permite la navegación si no hay restricciones
});

export default router;
