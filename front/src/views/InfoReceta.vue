<template>
    <div class="recipe-detail">
      <!-- Botón para volver atrás -->
      <button class="back-button" @click="goBack">← Volver</button>
  
      <!-- Título de la receta -->
      <h1 class="recipe-title">{{ recipe.title }}</h1>
  
      <!-- Imagen de la receta -->
      <div class="recipe-image-container">
        <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
      </div>
  
      <!-- Detalles de la receta -->
      <div class="recipe-info">
        <p class="recipe-description"><strong>Descripción:</strong> {{ recipe.description || 'Sin descripción' }}</p>
        <div class="recipe-section">
          <h2>Ingredientes</h2>
          <ul class="ingredients-list">
            <li v-for="(ingredient, index) in recipe.ingredients" :key="index">{{ ingredient }}</li>
          </ul>
        </div>
        <div class="recipe-section">
          <h2>Pasos</h2>
          <ol class="steps-list">
            <li v-for="(step, index) in recipe.steps" :key="index">{{ step }}</li>
          </ol>
        </div>
        <div class="recipe-meta">
          <p><strong>Tiempo de preparación:</strong> {{ recipe.prep_time }} mins</p>
          <p><strong>Tiempo de cocción:</strong> {{ recipe.cook_time }} mins</p>
          <p><strong>Porciones:</strong> {{ recipe.servings }} personas</p>
          <p><strong>Likes:</strong> {{ recipe.likes_count }} ❤️</p> <br>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import communicationManager from '@/services/communicationManager';
  
  export default {
    data() {
      return {
        recipe: {
          title: '',
          image: '',
          description: '',
          ingredients: [],
          steps: [],
          prep_time: 0,
          cook_time: 0,
          servings: 0,
          likes_count: 0,
        },
      };
    },
    async created() {
      const recipeId = this.$route.params.recipeId; // Obtener el ID de la receta desde la URL
      try {
        const data = await communicationManager.fetchRecipeDetails(recipeId); // Función para obtener los detalles
        this.recipe = data;
      } catch (error) {
        console.error('Error fetching recipe details:', error);
      }
    },
    methods: {
      goBack() {
        this.$router.go(-1); // Volver a la página anterior
      },
    },
  };
  </script>
  
  <style scoped>
  .recipe-detail {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  
  .back-button {
    background-color: #63c132;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
  }
  
  .back-button:hover {
    background-color: #358600;
  }
  
  .recipe-title {
    font-size: 2.5em;
    color: #343330;
    text-align: center;
    margin-bottom: 20px;
  }
  
  .recipe-image-container {
    width: 100%;
    max-height: 400px;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 20px;
  }
  
  .recipe-image {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 12px;
  }
  
  .recipe-info {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
  }
  
  .recipe-description {
    font-size: 1.1em;
    line-height: 1.6;
    color: #555;
    margin-bottom: 20px;
  }
  
  .recipe-section {
    margin-bottom: 20px;
  }
  
  .recipe-section h2 {
    font-size: 1.8em;
    color: #358600;
    margin-bottom: 10px;
  }
  
  .ingredients-list,
  .steps-list {
    list-style-type: none;
    padding: 0;
  }
  
  .ingredients-list li,
  .steps-list li {
    background-color: #fff;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
  }
  
  .ingredients-list li:hover,
  .steps-list li:hover {
    transform: translateY(-2px);
  }
  
  .recipe-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
  }
  
  .recipe-meta p {
    background-color: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 1em;
    color: #555;
    margin: 0;
  }
  
  @media (max-width: 768px) {
    .recipe-title {
      font-size: 2em;
    }
  
    .recipe-image-container {
      max-height: 300px;
    }
  
    .recipe-description {
      font-size: 1em;
    }
  
    .recipe-section h2 {
      font-size: 1.5em;
    }
  
    .recipe-meta {
      flex-direction: column;
      gap: 10px;
    }
  }
  </style>