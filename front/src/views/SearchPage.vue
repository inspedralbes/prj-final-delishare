<template>
  <div>
    <!-- Buscador y filtros -->
    <div class="search-container">
      <input type="text" v-model="searchQuery" placeholder="Busca tu receta..." />
      <div class="filters">
        <button>Tiempo</button>
        <button>Categoría</button>
        <button>Cuisine</button>
        <button>Imágenes</button>
        <button>Usuario</button>
      </div>
    </div>

    <!-- Resultados de búsqueda (cards de recetas) -->
    <div class="search-results">
      <div v-for="(recipe, index) in filteredRecipes" :key="index" class="search-item">
        <img :src="recipe.image" alt="Receta" />
        <div class="description">
          <h3>{{ recipe.title }}</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchPage',

  data() {
    return {
      searchQuery: '',
      recipes: [
        { image: new URL('@/assets/images/receta1.jpg', import.meta.url).href, description: 'Deliciosa receta de pasta', title: 'Pasta a la Bolognesa' },
        { image: new URL('@/assets/images/receta2.jpg', import.meta.url).href, description: 'Deliciosa receta de ensalada', title: 'Ensalada Griega' },
        { image: new URL('@/assets/images/receta3.jpg', import.meta.url).href, description: 'Receta fácil de pollo al horno', title: 'Pollo al Horno' },
        { image: new URL('@/assets/images/receta4.jpg', import.meta.url).href, description: 'Receta vegetariana con quinoa', title: 'Quinoa Veggie' },
        { image: new URL('@/assets/images/receta5.jpg', import.meta.url).href, description: 'Deliciosa pizza margarita', title: 'Pizza Margarita' },
        { image: new URL('@/assets/images/receta6.jpg', import.meta.url).href, description: 'Receta de tacos de pescado', title: 'Tacos de Pescado' },
        { image: new URL('@/assets/images/receta7.jpg', import.meta.url).href, description: 'Sopa fácil y saludable', title: 'Sopa de Tomate' },
        { image: new URL('@/assets/images/receta8.jpg', import.meta.url).href, description: 'Deliciosos brownies de chocolate', title: 'Brownies' },
        { image: new URL('@/assets/images/receta9.jpg', import.meta.url).href, description: 'Tarta de manzana casera', title: 'Tarta de Manzana' },
      ],
    };
  },
  computed: {
    filteredRecipes() {
      return this.recipes.filter((recipe) => 
        recipe.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    saveRecipe(recipe) {
      console.log('Guardando receta:', recipe.title);
    },
  },
};
</script>

<style scoped>
.search-container {
  padding: 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.search-container input {
  padding: 10px;
  width: 100%;
  max-width: 400px;
  margin-bottom: 20px;
  border: 1px solid #343330;
  border-radius: 5px;
  transition: border-color 0.3s ease;
}

.search-container input:focus {
  border-color: #4CAF50; /* Verde oscuro */
  outline: none;
}

.filters {
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap;
}

.filters button {
  padding: 10px 15px;
  background-color: #388E3C; /* Verde oscuro */
  color: white;
  border: none;
  cursor: pointer;
  margin: 5px;
  min-width: 100px;
}

.filters button:hover {
  background-color: #2C6B29; /* Verde más oscuro */
}

.search-results {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  padding: 20px;
  margin-bottom: 40px;
}

.search-item {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  max-width: 350px;
  height: 350px;
  font-size: 14px;
}

.search-item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.search-item .description {
  padding: 10px;
}

.search-item h3 {
  font-size: 1rem;
  margin: 0;
}

@media (max-width: 768px) {
  .search-results {
    grid-template-columns: repeat(2, 1fr);
  }

  .search-item {
    max-width: 150px;
    height: 150px;
    font-size: 14px;
  }

  .filters button {
    min-width: 80px;
    border-radius: 9px;
  }
}
</style>
