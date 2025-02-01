<template>
  <div class="container">
    <h1>Crear Nueva Receta</h1>
    <div class="form-container">
      <form @submit.prevent="submitRecipe">
        <input type="hidden" v-model="recipe.user_id" />

        <div>
          <label for="category">Categoría:</label>
          <select v-model="recipe.category_id" required>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <div>
          <label for="cuisine">Cocina:</label>
          <select v-model="recipe.cuisine_id" required>
            <option v-for="cuisine in cuisines" :key="cuisine.id" :value="cuisine.id">
              {{ cuisine.country }}
            </option>
          </select>
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
          <div v-for="(ingredient, index) in recipe.ingredients" :key="index" class="inline-group">
            <input type="text" v-model="recipe.ingredients[index]" placeholder="Añadir ingrediente" />
            <button type="button" @click="removeIngredient(index)">-</button>
          </div>
          <button type="button" @click="addIngredient">+</button>
        </div>

        <div>
          <label>Pasos:</label>
          <div v-for="(step, index) in recipe.steps" :key="index" class="inline-group">
            <input type="text" v-model="recipe.steps[index]" placeholder="Añadir paso" />
            <button type="button" @click="removeStep(index)">-</button>
          </div>
          <button type="button" @click="addStep">+</button>
        </div>

        <div>
          <label>Información Nutricional:</label>
          <div v-for="(nutrient, index) in recipe.nutrition" :key="index" class="inline-group">
            <input type="text" v-model="recipe.nutrition[index].key" placeholder="Nombre (ej. calorías)" />
            <input type="text" v-model="recipe.nutrition[index].value" placeholder="Valor (ej. 250)" />
            <button type="button" @click="removeNutrition(index)">-</button>
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

        <div>
          <label for="image">Subir Imagen:</label>
          <input type="file" @change="onFileChange" />
          <button type="button" @click="uploadImage">Subir Imagen</button>
          <img v-if="recipe.image" :src="recipe.image" alt="Imagen subida" class="preview-image" />
        </div>

        <button type="submit">Crear Receta</button>
      </form>
    </div>

    <div v-if="message" :class="messageClass">{{ message }}</div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import communicationManager from '@/services/communicationManager';

const cloudName = 'dt5vjbgab'; 
const uploadPreset = 'ejemplo1';

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
      cuisine_id: null,
      image: null
    });

    const selectedFile = ref(null);
    const message = ref('');
    const messageClass = ref('');

    onMounted(async () => {
      try {
        user.value = await communicationManager.getUser();
        categories.value = await communicationManager.fetchCategories();
        cuisines.value = await communicationManager.fetchCuisines();
      } catch (error) {
        console.error("Error obteniendo datos:", error);
      }
    });

    const addIngredient = () => recipe.value.ingredients.push('');
    const removeIngredient = (index) => recipe.value.ingredients.splice(index, 1);
    const addStep = () => recipe.value.steps.push('');
    const removeStep = (index) => recipe.value.steps.splice(index, 1);
    const addNutrition = () => recipe.value.nutrition.push({ key: '', value: '' });
    const removeNutrition = (index) => recipe.value.nutrition.splice(index, 1);

    const onFileChange = (e) => {
      selectedFile.value = e.target.files[0];
    };

    const uploadImage = async () => {
      if (!selectedFile.value) return;

      const formData = new FormData();
      formData.append('file', selectedFile.value);
      formData.append('upload_preset', uploadPreset);

      try {
        const response = await axios.post(
          `https://api.cloudinary.com/v1_1/${cloudName}/image/upload`,
          formData
        );
        recipe.value.image = response.data.secure_url;
      } catch (error) {
        console.error('Error al subir la imagen:', error);
      }
    };

    const submitRecipe = async () => {
      if (!user.value) {
        console.error("Usuario no autenticado");
        return;
      }

      try {
        await communicationManager.createRecipe({
          ...recipe.value,
          user_id: user.value.id
        });
        message.value = "Receta creada con éxito!";
        messageClass.value = 'success';
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
      removeIngredient,
      addStep,
      removeStep,
      addNutrition,
      removeNutrition,
      onFileChange,
      uploadImage,
      submitRecipe,
      message,
      messageClass
    };
  }
};
</script>

<style scoped>
.container {
  width: 100%;
  max-width: 600px;
  margin: auto;
}

.form-container {
  max-height: 500px; /* Altura máxima */
  overflow-y: auto; /* Permitir scroll */
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.inline-group {
  display: flex;
  gap: 10px;
  margin-bottom: 5px;
}

.preview-image {
  max-width: 100%;
  height: auto;
  margin-top: 10px;
}

.success {
  color: green;
}

.error {
  color: red;
}
</style>
