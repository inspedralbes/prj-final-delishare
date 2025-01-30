<template>
    <div>
      <h1>Crear Nueva Receta</h1>
      <form @submit.prevent="submitRecipe">
        <!-- ID de Usuario (sin mostrar) -->
        <input type="hidden" v-model="recipe.user_id" />
    
        <!-- Categorías -->
        <div>
          <label for="category">Categoría:</label>
          <select v-model="recipe.category_id" required>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
    
        <!-- Cocinas -->
        <div>
          <label for="cuisine">Cocina:</label>
          <select v-model="recipe.cuisine_id" required>
            <option v-for="cuisine in cuisines" :key="cuisine.id" :value="cuisine.id">
              {{ cuisine.country }}
            </option>
          </select>
        </div>
    
        <!-- Título -->
        <div>
          <label for="title">Título:</label>
          <input type="text" id="title" v-model="recipe.title" required />
        </div>
    
        <!-- Descripción -->
        <div>
          <label for="description">Descripción:</label>
          <textarea id="description" v-model="recipe.description" required></textarea>
        </div>
    
        <!-- Ingredientes -->
        <div>
          <label>Ingredientes:</label>
          <div v-for="(ingredient, index) in recipe.ingredients" :key="index">
            <input type="text" v-model="recipe.ingredients[index]" placeholder="Añadir ingrediente" />
          </div>
          <button type="button" @click="addIngredient">+</button>
        </div>
    
        <!-- Pasos -->
        <div>
          <label>Pasos:</label>
          <div v-for="(step, index) in recipe.steps" :key="index">
            <input type="text" v-model="recipe.steps[index]" placeholder="Añadir paso" />
          </div>
          <button type="button" @click="addStep">+</button>
        </div>
    
        <!-- Información Nutricional -->
        <div>
          <label>Información Nutricional:</label>
          <div v-for="(nutrient, index) in recipe.nutrition" :key="index">
            <input type="text" v-model="recipe.nutrition[index].key" placeholder="Nombre (ej. calorías)" />
            <input type="text" v-model="recipe.nutrition[index].value" placeholder="Valor (ej. 250)" />
          </div>
          <button type="button" @click="addNutrition">+</button>
        </div>
    
        <!-- Tiempo de Preparación -->
        <div>
          <label for="prepTime">Tiempo de Preparación (minutos):</label>
          <input type="number" id="prepTime" v-model="recipe.prep_time" required />
        </div>
    
        <!-- Tiempo de Cocción -->
        <div>
          <label for="cookTime">Tiempo de Cocción (minutos):</label>
          <input type="number" id="cookTime" v-model="recipe.cook_time" required />
        </div>
    
        <!-- Porciones -->
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
  import { ref, onMounted } from 'vue';
  import communicationManager from '@/services/communicationManager';
  
  export default {
    setup() {
      const user = ref(null);
      const categories = ref([]);
      const cuisines = ref([]);
      const recipe = ref({
        title: '',
        description: '',
        ingredients: [],
        steps: [],
        nutrition: [],
        prep_time: 0,
        cook_time: 0,
        servings: 0,
        category_id: null,
        cuisine_id: null
      });
  
      const message = ref('');
      const messageClass = ref('');
  
      // Cargar datos del usuario autenticado y categorías/cocinas
      onMounted(async () => {
        try {
          user.value = await communicationManager.getUser();
          categories.value = await communicationManager.fetchCategories();
          cuisines.value = await communicationManager.fetchCuisines();
        } catch (error) {
          console.error("Error obteniendo datos:", error);
        }
      });
  
      const addIngredient = () => {
        recipe.value.ingredients.push('');
      };
  
      const addStep = () => {
        recipe.value.steps.push('');
      };
  
      const addNutrition = () => {
        recipe.value.nutrition.push({ key: '', value: '' });
      };
  
      const submitRecipe = async () => {
        if (!user.value) {
          console.error("Usuario no autenticado");
          return;
        }
  
        try {
          await communicationManager.createRecipe({
            ...recipe.value,
            user_id: user.value.id // Agrega el ID del usuario autenticado
          });
          message.value = "Receta creada con éxito!";
          messageClass.value = 'success';
  
          // Vaciar los campos después de crear la receta
          recipe.value = {
            title: '',
            description: '',
            ingredients: [],
            steps: [],
            nutrition: [],
            prep_time: 0,
            cook_time: 0,
            servings: 0,
            category_id: null,
            cuisine_id: null
          };
  
        } catch (error) {
          message.value = "Error creando receta!";
          messageClass.value = 'error';
          console.error("Error creando receta:", error);
        }
      };
  
      return {
        recipe,
        categories,
        cuisines,
        addIngredient,
        addStep,
        addNutrition,
        submitRecipe,
        message,
        messageClass
      };
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
  