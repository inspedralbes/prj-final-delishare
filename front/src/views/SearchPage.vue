<template>
  <div class="search-page">
    <h1>Recetas Disponibles</h1>

    <!-- Mostrar mensaje de carga mientras se obtienen las recetas -->
    <div v-if="loading" class="loading">
      Cargando recetas...
    </div>

    <!-- Mostrar las recetas cuando se han cargado -->
    <div v-else>
      <div v-if="recipes.length === 0" class="no-recipes">
        No hay recetas disponibles.
      </div>

      <div class="recipe-list">
        <div v-for="recipe in recipes" :key="recipe.id" class="recipe-card">
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
      recipes: [] // Aquí se guardarán las recetas
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
        const response = await fetch('http://127.0.0.1:8000/api/getAllRecipes'); // URL a tu API
        const data = await response.json();
        this.recipes = data.recipes; // Asumimos que la respuesta tiene una clave 'recipes'
      } catch (error) {
        console.error('Error al obtener las recetas:', error);
      } finally {
        this.loading = false; // Ya se cargaron las recetas
      }
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

h2 {
  text-align: center;
  color: #358600;
  font-size: 1.5em;
  margin-bottom: 20px;
}

/* Grid de recetas */
.recipe-list {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 columnas */
  gap: 20px; /* Aumento del espacio entre tarjetas */
  justify-items: center; /* Centra las tarjetas en el contenedor */
  margin-top: 20px;
}

.recipe-card {
  width: 100%;
  max-width: 220px; /* Tamaño ajustado */
  height: 250px; /* Ajuste de altura */
  border: 1px solid #343330;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out, background-color 0.3s;
  text-align: center;
  margin: 0 10px; /* Margen izquierdo y derecho */
}

/* Hacer que la tarjeta sea clickeable */
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

  .recipe-card {
    max-width: 200px; /* Ajustado para no ser tan grandes */
    height: 250px;
    font-size: 14px;
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
