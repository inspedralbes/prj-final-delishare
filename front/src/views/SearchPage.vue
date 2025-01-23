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

    <!-- Navbar en la parte inferior -->
    <Navbar />
  </div>
</template>

<script>
// Importa el componente Navbar
import Navbar from '@/components/Navbar.vue';

export default {
  name: 'SearchPage',
  components: {
    Navbar, // Registra el componente Navbar
  },
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
/* Estilos para la página de búsqueda */

/* Contenedor principal del buscador */
.search-container {
  padding: 20px;
  text-align: center;
}

/* Estilo del input */
.search-container input {
  padding: 10px;
  width: 100%;
  max-width: 400px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Estilos para los botones de filtros */
.filters {
  display: flex;
  flex-direction: column;  /* Flex dirección columna para pantallas pequeñas */
  align-items: center;
}

.filters button {
  padding: 10px 15px;
  background-color: #ff6347;
  color: white;
  border: none;
  cursor: pointer;
  margin: 5px 0;
  width: 80%;  /* Botones ocupando el 80% del ancho */
}

.filters button:hover {
  background-color: #e55347;
}

/* Estilos para los resultados de búsqueda (cards) */
.search-results {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 columnas */
  gap: 20px; /* Espacio entre las tarjetas */
  padding: 20px;
}

.search-item {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  max-width: 350px; /* Tamaño de la tarjeta para pantallas grandes */
  height: 350px; /* Altura fija para tarjetas */
  font-size: 14px; /* Tamaño de fuente para pantallas grandes */
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
  font-size: 1.2rem;
  margin: 0;
}

/* Media Query para pantallas más pequeñas (móviles) */
@media (max-width: 768px) {
  .search-results {
    grid-template-columns: repeat(2, 1fr); /* 2 columnas en dispositivos más pequeños */
  }

  .search-item {
    max-width: 150px; /* Tamaño de la tarjeta para pantallas móviles */
    height: 150px;
    font-size: 14px; /* Tamaño de fuente más pequeño para móviles */
  }
}
</style>
