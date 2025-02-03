<template>
  <div class="search-page">
    <h1>Recetas Disponibles</h1>

    <!-- Campo de búsqueda -->
    <div class="search-bar">
      <input type="text" v-model="searchQuery" placeholder="Buscar recetas..." />
    </div>

    <!-- Componente de botones de filtro -->
    <Botones @filtrarPorCategoria="filtrarPorCategoria" @filtrarPorCuisine="filtrarPorCuisine" @filtrarPorTiempo="filtrarPorTiempo" @filtrarPorUsuario="filtrarPorUsuario" />

    <!-- Mostrar mensaje de carga mientras se obtienen las recetas -->
    <div v-if="loading" class="loading">
      Cargando recetas...
    </div>

    <!-- Mostrar las recetas cuando se han cargado -->
    <div v-else>
      <div v-if="filteredRecipes.length === 0" class="no-recipes">
        No hay recetas disponibles.
      </div>

      <div class="recipe-list">
        <RecipeCard
          v-for="recipe in filteredRecipes"
          :key="recipe.id"
          :recipeId="recipe.id"
          :title="recipe.title"
          :description="recipe.description || 'Descripción no disponible'"
          :image="recipe.image"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Botones from '../components/Botones.vue';
import RecipeCard from '../components/RecipeCard.vue';

export default {
  components: {
    Botones,
    RecipeCard
  },
  data() {
    return {
      loading: true,
      recipes: [],
      searchQuery: '',
      filtros: {
        categoria: '',
        cuisine: '',
        tiempo: '',
        usuario: ''
      }
    };
  },
  mounted() {
    this.fetchRecipes();
  },
  methods: {
    async fetchRecipes() {
      try {
        const response = await fetch('http://delishare.daw.inspedralbes.cat/public/api/getAllRecipes');
        const data = await response.json();
        this.recipes = data.recipes;
      } catch (error) {
        console.error('Error al obtener las recetas:', error);
      } finally {
        this.loading = false;
      }
    },
    filtrarPorCategoria(categoria) {
      this.filtros.categoria = categoria;
    },
    filtrarPorCuisine(cuisine) {
      this.filtros.cuisine = cuisine;
    },
    filtrarPorTiempo(tiempo) {
      this.filtros.tiempo = tiempo;
    },
    filtrarPorUsuario(usuario) {
      this.filtros.usuario = usuario;
    }
  },
  computed: {
    filteredRecipes() {
      return this.recipes.filter(recipe => {
        const matchesSearch = recipe.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          (recipe.description && recipe.description.toLowerCase().includes(this.searchQuery.toLowerCase()));

        const matchesCategoria = this.filtros.categoria ? recipe.category === this.filtros.categoria : true;
        const matchesCuisine = this.filtros.cuisine ? recipe.cuisine === this.filtros.cuisine : true;
        const matchesTiempo = this.filtros.tiempo ? recipe.time === this.filtros.tiempo : true;
        const matchesUsuario = this.filtros.usuario ? recipe.user === this.filtros.usuario : true;

        return matchesSearch && matchesCategoria && matchesCuisine && matchesTiempo && matchesUsuario;
      });
    }
  }
};
</script>

<style scoped>
.search-page {
  padding: 20px;
  background-color: #f5f5f5;
}

h1 {
  text-align: center;
  color: #358600;
}

.search-bar {
  text-align: center;
  margin-bottom: 20px;
}

.search-bar input {
  padding: 10px;
  width: 70%;
  max-width: 400px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
}

.loading, .no-recipes {
  text-align: center;
  font-size: 1.2em;
  color: #358600;
}

.recipe-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 20px;
  justify-items: center;
  margin-top: 20px;
}

@media (min-width: 768px) {
  .recipe-list {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>