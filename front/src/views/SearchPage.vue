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

    <!-- Resultados de búsqueda -->
    <div class="search-results">
      <div v-for="(recipe, index) in filteredRecipes" :key="index" class="search-item">
        <img :src="recipe.image" alt="Receta" />
        <div class="description">
          <p>{{ recipe.description }}</p>
          <button @click="saveRecipe(recipe)">Guardar</button>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <p>&copy; 2025 Recetas Deliciosas | Diseñado con amor</p>
      <p>Síguenos en <a href="#">Instagram</a></p>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      // Carga las imágenes con import en lugar de require
      recipes: [
        { image: new URL('@/assets/images/receta1.jpg', import.meta.url).href, description: 'Deliciosa receta de pasta', title: 'Pasta a la Bolognesa' },
        { image: new URL('@/assets/images/receta2.jpg', import.meta.url).href, description: 'Deliciosa receta de ensalada', title: 'Ensalada Griega' },
        { image: new URL('@/assets/images/receta3.jpg', import.meta.url).href, description: 'Receta fácil de pollo al horno', title: 'Pollo al Horno' },
        // Aquí puedes agregar más recetas
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
/* Estilos para la página de búsqueda - Mobile-first */

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

/* Estilos para los resultados de búsqueda */
.search-results {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.search-item {
  width: 100%;
  max-width: 320px; /* Ancho máximo */
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.search-item img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.search-item .description {
  padding: 10px;
}

.search-item button {
  background-color: #ff6347;
  color: white;
  border: none;
  padding: 10px 15px;
  cursor: pointer;
  width: 100%;
}

.search-item button:hover {
  background-color: #e55347;
}

/* Footer */
.footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 10px 0;
}

.footer a {
  color: #ff6347;
  text-decoration: none;
}

/* Media Queries para pantallas más grandes */

/* En dispositivos mayores a 600px (tabletas y mayores) */
@media (min-width: 600px) {
  .filters {
    flex-direction: row;  /* Botones en fila */
  }

  .filters button {
    width: 20%; /* Los botones ocupan el 20% del ancho */
  }

  .search-results {
    flex-wrap: wrap;  /* Los elementos de búsqueda se alinean en múltiples líneas */
    justify-content: space-around;
  }

  .search-item {
    width: 30%;  /* Ancho de los resultados más pequeño */
  }
}

/* En dispositivos mayores a 1024px (pantallas grandes) */
@media (min-width: 1024px) {
  .search-container input {
    width: 50%;  /* Campo de búsqueda más grande */
  }

  .search-item {
    width: 22%;  /* Resultados más pequeños y ajustados */
  }
}
</style>
