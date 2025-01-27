<template>
  <div v-if="recipe" class="recipe-detail">
    <h1>{{ recipe.title }}</h1>
    <div class="recipe-image">
      <img :src="recipe.image" alt="Image of {{ recipe.title }}" />
    </div>
    <div class="recipe-info">
      <p><strong>Categoría:</strong> {{ recipe.category_id }}</p>
      <p><strong>Cocina:</strong> {{ recipe.cuisine_id }}</p>
      <p><strong>Tiempo de preparación:</strong> {{ recipe.prep_time }} minutos</p>
      <p><strong>Tiempo de cocción:</strong> {{ recipe.cook_time }} minutos</p>
      <p><strong>Porciones:</strong> {{ recipe.servings }}</p>
    </div>
    <div class="recipe-description">
      <h2>Descripción</h2>
      <p>{{ recipe.description }}</p>
    </div>
    <div class="recipe-ingredients">
      <h2>Ingredientes</h2>
      <ul>
        <li v-for="(ingredient, index) in recipe.ingredients.split(',')" :key="index">
          {{ ingredient.trim() }}
        </li>
      </ul>
    </div>
    <div class="recipe-steps">
      <h2>Instrucciones</h2>
      <ol>
        <li v-for="(step, index) in recipe.steps.split('.')" :key="index">
          {{ step.trim() }}
        </li>
      </ol>
    </div>
  </div>
  <div v-else class="loading">
    <p>Cargando receta...</p>
  </div>
</template>

<script>
export default {
  name: 'RecipeDetailPage',
  data() {
    return {
      recipe: null,
      error: null,
    };
  },
  created() {
    this.fetchRecipe();
  },
  methods: {
    async fetchRecipe() {
      const recipeId = this.$route.params.id; // Asumiendo que el id de la receta está en la ruta
      try {
        const response = await fetch(`/api/recipes/${recipeId}`);
        if (!response.ok) {
          throw new Error('Error al obtener los datos de la receta');
        }
        const data = await response.json();
        this.recipe = data;
      } catch (error) {
        this.error = error;
        console.error('Error al cargar la receta:', error);
      }
    },
  },
};
</script>

<style scoped>
.recipe-detail {
  padding: 20px;
}
.recipe-image img {
  max-width: 100%;
  height: auto;
}
.recipe-info p {
  font-size: 16px;
}
.recipe-description, .recipe-ingredients, .recipe-steps {
  margin-top: 20px;
}
.loading {
  font-size: 18px;
  color: gray;
}
</style>
