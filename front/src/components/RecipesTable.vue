<template>
  <div>
    <h1>Recetas</h1>
    <div v-if="loading">Cargando recetas...</div>
    <div v-else>
      <div v-if="error" class="error-message">
        Error al cargar las recetas: {{ error }}
      </div>
      <div v-if="recipes.length > 0" class="recipe-cards">
        <div v-for="recipe in recipes" :key="recipe.id" class="card">
          <div class="card-header">
            <h2>{{ recipe.title }}</h2>
          </div>
          <div class="card-body">
            <p><strong>Descripción:</strong> {{ recipe.description || 'Sin descripción' }}</p>
            <p><strong>Ingredientes:</strong> {{ recipe.ingredients.join(', ') || 'Sin ingredientes' }}</p>
            <p><strong>Pasos:</strong> {{ recipe.steps.join(', ') || 'Sin pasos' }}</p>
            <p><strong>Tiempo de preparación:</strong> {{ recipe.prep_time }} mins</p>
            <p><strong>Tiempo de cocción:</strong> {{ recipe.cook_time }} mins</p>
            <p><strong>Porciones:</strong> {{ recipe.servings }} personas</p>
            <p><strong>Likes:</strong> {{ recipe.likes_count }} personas</p>

          </div>
        </div>
      </div>
      <div v-else>No hay recetas disponibles.</div>
    </div>
  </div>
</template>

<script>
import communicationManager from "@/services/communicationManager";

export default {
  data() {
    return {
      recipes: [],
      loading: true,
      error: null,
    };
  },
  async created() {
    try {
      this.recipes = await communicationManager.fetchRecipes();
    } catch (error) {
      console.error("Error fetching recipes:", error);
      this.error = error.message || "Error desconocido";
    } finally {
      this.loading = false;
    }
  },
};
</script>

<style>
/* Estilos para las tarjetas */
.recipe-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.card {
  width: 300px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  background-color: #fff;
}

.card-header {
  background-color: #f4f4f4;
  padding: 10px;
  border-radius: 5px;
  text-align: center;
}

.card-body {
  padding: 10px 0;
}

.card-body p {
  margin: 10px 0;
}

.error-message {
  color: red;
  font-weight: bold;
  margin-top: 20px;
}
</style>
