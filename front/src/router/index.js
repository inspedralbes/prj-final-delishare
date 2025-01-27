import { createRouter, createWebHistory } from 'vue-router';
import RecipesTable from '@/components/RecipesTable.vue'; // Ajusta si el archivo tiene otro nombre o ruta

const routes = [
  {
    path: '/recipes',
    name: 'RecipesTable',
    component: RecipesTable,
  },
];

const router = createRouter({
  history: createWebHistory(), // Usa el historial del navegador para manejar rutas
  routes,
});

export default router;
