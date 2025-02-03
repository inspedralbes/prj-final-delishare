<template>
  <div class="search-page">
    <h1>Recetas Disponibles</h1>

    <!-- Campo de búsqueda -->
    <div class="search-bar">
      <input type="text" v-model="searchQuery" placeholder="Buscar recetas..." />
    </div>

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
        <div v-for="recipe in filteredRecipes" :key="recipe.id" class="recipe-card">
          <!-- Enlace a la página de detalles de la receta -->
          <router-link :to="{ name: 'InfoReceta', params: { recipeId: recipe.id } }" class="recipe-link">
            <!-- Imagen de la receta -->
            <img v-if="recipe.image" :src="recipe.image" alt="Imagen de receta" class="recipe-image">
            
            <div class="recipe-info">
              <!-- Título de la receta -->
              <h2 class="recipe-title">{{ recipe.title }}</h2>
              <p>{{ recipe.description || 'Descripción no disponible' }}</p>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true, // Para indicar si estamos cargando las recetas
      recipes: [], // Aquí se guardarán las recetas
      searchQuery: '' // Término de búsqueda
    };
  },
  mounted() {
    // Cuando el componente se monte, obtenemos las recetas
    this.fetchRecipes();
  },
  methods: {
    // Método para hacer la llamada a la API y obtener todas las recetas
    async fetchRecipes() {
      try {
        const response = await fetch('http://delishare.daw.inspedralbes.cat/public/api/getAllRecipes'); // URL a tu API
        const data = await response.json();
        this.recipes = data.recipes; // Asumimos que la respuesta tiene una clave 'recipes'
      } catch (error) {
        console.error('Error al obtener las recetas:', error);
      } finally {
        this.loading = false; // Ya se cargaron las recetas
      }
    }
  },
  computed: {
    // Computed property para filtrar las recetas basadas en la búsqueda
    filteredRecipes() {
      return this.recipes.filter(recipe => 
        recipe.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        (recipe.description && recipe.description.toLowerCase().includes(this.searchQuery.toLowerCase()))
      );
    }
  }
};
</script>

<style scoped>
/* Estilos generales */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #f5f5f5;
  color: #343330;
  margin-bottom: 30px;
  margin-top: 20px;
}

h1 {
  text-align: center;
  color: #358600;
  font-size: 2em;
  margin-bottom: 20px;
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

.loading {
  text-align: center;
  font-size: 1.2em;
  color: #358600;
}

.no-recipes {
  text-align: center;
  font-size: 1.2em;
  color: #666;
}

.recipe-list {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 columnas */
  gap: 20px; /* Aumento del espacio entre tarjetas */
  justify-items: center; /* Centra las tarjetas en el contenedor */
  margin-top: 20px;
}

.recipe-card {
  width: 100px;
  max-width: 220px;
  height: 150px;
  border: 1px solid #343330;
  border-radius: 8px;
  overflow: hidden;
  text-align: center;
  margin-left: 5px;
  margin-right: 5px;
}


.recipe-card .recipe-link {
  display: block;
  text-decoration: none;
  color: inherit;
  height: 100%;
}

/* Efecto hover en la tarjeta */
.recipe-card:hover {
  transform: scale(1.05);
}

.recipe-image {
  width: 100%;
  height: 60%;
  object-fit: cover;
}

.recipe-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 40%;
}

.recipe-title {
  font-weight: bold;
  font-size: 12px; /* Título más pequeño */
  color: #343330;
  margin-top: 5px;
}

.recipe-description {
  font-size: 10px;
  color: #666;
  margin: 5px 0;
}

/* Ajustes para pantallas medianas y grandes */
@media (min-width: 768px) {
  .recipe-list {
    grid-template-columns: repeat(3, 1fr); /* 3 columnas en pantallas medianas */
  }



  .recipe-title {
    font-size: 14px;
  }
}

@media (min-width: 1024px) {
  .recipe-list {
    grid-template-columns: repeat(3, 1fr); /* 3 columnas en pantallas grandes */
  }

  .recipe-card {
    max-width: 220px;
    height: 250px;
    font-size: 16px;
    
  }

  .recipe-title {
    font-size: 16px;
  }
}
</style>
