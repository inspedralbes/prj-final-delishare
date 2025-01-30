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
          <label>Ingredientes:</label>
          <div v-for="(ingredient, index) in recipe.ingredients" :key="index">
            <input type="text" v-model="recipe.ingredients[index]" placeholder="Añadir ingrediente" />
          </div>
          <button type="button" @click="addIngredient">+</button>
        </div>
  
        <div>
          <label>Pasos:</label>
          <div v-for="(step, index) in recipe.steps" :key="index">
            <input type="text" v-model="recipe.steps[index]" placeholder="Añadir paso" />
          </div>
          <button type="button" @click="addStep">+</button>
        </div>
  
        <div>
          <label>Información Nutricional:</label>
          <div v-for="(nutrient, index) in recipe.nutrition" :key="index">
            <input type="text" v-model="recipe.nutrition[index].key" placeholder="Nombre (ej. calorías)" />
            <input type="text" v-model="recipe.nutrition[index].value" placeholder="Valor (ej. 250)" />
          </div>
          <button type="button" @click="addNutrition">+</button>
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
  
        <button type="submit">Crear Receta</button>
      </form>
  
      <div v-if="message" :class="messageClass">{{ message }}</div>
    </div>
  </template>
  
  <script>
  import communicationManager from '@/services/communicationManager';
  
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
          nutrition: []
        },
        message: '',
        messageClass: ''
      };
    },
    methods: {
      addIngredient() {
        this.recipe.ingredients.push('');
      },
      addStep() {
        this.recipe.steps.push('');
      },
      addNutrition() {
        this.recipe.nutrition.push({ key: '', value: '' });
      },
      async submitRecipe() {
        try {
          // Convertir información nutricional a JSON válido
          this.recipe.nutrition = this.recipe.nutrition.map(n => ({ [n.key]: n.value }));
  
          const response = await communicationManager.createRecipe(this.recipe);
          this.message = 'Receta creada con éxito!';
          this.messageClass = 'success';
          console.log('Receta creada:', response.data);
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
          nutrition: []
        };
      }
    }
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
  