import { createRouter, createWebHistory } from 'vue-router';
import RecipesTable from '@/components/RecipesTable.vue'; // Ajusta si el archivo tiene otro nombre o ruta
import LandingPage from '@/views/LandingPage.vue';
import SearchPage from '@/views/SearchPage.vue';
import InfoReceta from '@/views/InfoReceta.vue'; // Importa el componente de la página de detalles

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
  },
  {
    path: '/search',  // Ruta de búsqueda
    name: 'SearchPage',
    component: SearchPage,  // El componente que se renderiza para la búsqueda
  },
  {
    path: '/info/:recipeId',  // Ruta con el parámetro de id de la receta
    name: 'InfoReceta',
    component: InfoReceta,
    props: true, // Habilita pasar el parámetro `recipeId` como prop al componente
  }
];

const router = createRouter({
  history: createWebHistory(), // Usa el historial del navegador para manejar rutas
  routes,
});

export default router;
