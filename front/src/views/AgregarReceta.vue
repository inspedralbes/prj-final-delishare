<template>
    <div>
      <h1>Crear Nueva Receta</h1>
      <form @submit.prevent="submitRecipe">
        <div>
          <label for="userId">ID de Usuario:</label>
          <input type="number" id="userId" v-model="recipe.user_id" required />
        </div>
  
        <div>
          <label for="categoryId">ID de Categoría:</label>
          <input type="number" id="categoryId" v-model="recipe.category_id" required />
        </div>
  
        <div>
          <label for="cuisineId">ID de Cocina:</label>
          <input type="number" id="cuisineId" v-model="recipe.cuisine_id" required />
        </div>
  
        <div>
          <label for="title">Título:</label>
          <input type="text" id="title" v-model="recipe.title" required />
        </div>
  
        <div>
          <label for="description">Descripción:</label>
          <textarea id="description" v-model="recipe.description" required></textarea>
        </div>
  
        <div>
          <label for="ingredients">Ingredientes (separados por comas):</label>
          <textarea id="ingredients" v-model="ingredientsInput" required></textarea>
        </div>
  
        <div>
          <label for="steps">Pasos (separados por comas):</label>
          <textarea id="steps" v-model="stepsInput" required></textarea>
        </div>
  
        <div>
          <label for="prepTime">Tiempo de Preparación (minutos):</label>
          <input type="number" id="prepTime" v-model="recipe.prep_time" required />
        </div>
  
        <div>
          <label for="cookTime">Tiempo de Cocción (minutos):</label>
          <input type="number" id="cookTime" v-model="recipe.cook_time" required />
        </div>
  
        <div>
          <label for="servings">Porciones:</label>
          <input type="number" id="servings" v-model="recipe.servings" required />
        </div>
  
        <div>
          <label for="nutrition">Información Nutricional (JSON):</label>
          <textarea id="nutrition" v-model="nutritionInput" required></textarea>
        </div>
  
        <button type="submit">Crear Receta</button>
      </form>
  
      <div v-if="message" :class="messageClass">{{ message }}</div>
    </div>
  </template>
  
  <script>
  import communicationManager from '@/components/services/communicationManager';
  
  export default {
    data() {
      return {
        recipe: {
          user_id: null,
          category_id: null,
          cuisine_id: null,
          title: '',
          description: '',
          ingredients: [],
          steps: [],
          prep_time: null,
          cook_time: null,
          servings: null,
          nutrition: [],
        },
        ingredientsInput: '',
        stepsInput: '',
        nutritionInput: '',
        message: '',
        messageClass: '',
      };
    },
    methods: {
      async submitRecipe() {
        try {
          // Convertir los inputs en los formatos correctos
          this.recipe.ingredients = this.ingredientsInput.split(',').map(item => item.trim());
          this.recipe.steps = this.stepsInput.split(',').map(item => item.trim());
          this.recipe.nutrition = JSON.parse(this.nutritionInput);
  
          // Enviar la receta usando el communicationManager
          const response = await communicationManager.createRecipe(this.recipe);
          this.message = 'Receta creada con éxito!';
          this.messageClass = 'success';
          console.log('Receta creada:', response.data);
  
          // Limpiar el formulario después de enviar
          this.resetForm();
        } catch (error) {
          this.message = 'Hubo un error al crear la receta. Por favor, intenta de nuevo.';
          this.messageClass = 'error';
          console.error('Error creando la receta:', error);
        }
      },
      resetForm() {
        this.recipe = {
          user_id: null,
          category_id: null,
          cuisine_id: null,
          title: '',
          description: '',
          ingredients: [],
          steps: [],
          prep_time: null,
          cook_time: null,
          servings: null,
          nutrition: [],
        };
        this.ingredientsInput = '';
        this.stepsInput = '';
        this.nutritionInput = '';
      },
    },
  };
  </script>
  
  <style scoped>
  .success {
    color: green;
  }
  
  .error {
    color: red;
  }
  </style>