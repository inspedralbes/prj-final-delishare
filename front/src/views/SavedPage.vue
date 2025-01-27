<template>
    <div class="saved-page">
      <h1>Recetas Guardadas</h1>
  
      <!-- Lista de recetas guardadas -->
      <div class="saved-recipes">
        <div 
          v-for="(recipe, index) in savedRecipes" 
          :key="index" 
          class="recipe-card"
        >
          <img :src="recipe.image" alt="Receta" />
          <div class="recipe-info">
            <h3>{{ recipe.title }}</h3>
            <p>{{ recipe.description }}</p>
          </div>
        </div>
      </div>
  
      <!-- Mensaje si no hay recetas guardadas -->
      <div v-if="savedRecipes.length === 0" class="empty-message">
        <p>No tienes recetas guardadas todavía. ¡Guarda tus favoritas para verlas aquí!</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'SavedPage',
    data() {
      return {
        savedRecipes: [
          {
            image: new URL('@/assets/images/receta1.jpg', import.meta.url).href,
            title: 'Pasta a la Bolognesa',
            description: 'Deliciosa receta de pasta con salsa bolognesa clásica.',
          },
          {
            image: new URL('@/assets/images/receta5.jpg', import.meta.url).href,
            title: 'Pizza Margarita',
            description: 'Clásica pizza margarita con albahaca fresca.',
          },
          {
            image: new URL('@/assets/images/receta8.jpg', import.meta.url).href,
            title: 'Brownies de Chocolate',
            description: 'Brownies fáciles y deliciosos, perfectos para postre.',
          },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .saved-page {
    padding: 20px;
    text-align: center;
  }
  
  h1 {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  
  .saved-recipes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
  }
  
  .recipe-card {
    background: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
  }
  
  .recipe-card:hover {
    transform: scale(1.03);
  }
  
  .recipe-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }
  
  .recipe-info {
    padding: 15px;
    text-align: left;
  }
  
  .recipe-info h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #333;
  }
  
  .recipe-info p {
    font-size: 0.9rem;
    color: #666;
    margin-top: 5px;
  }
  
  .empty-message {
    font-size: 1.2rem;
    color: #666;
    margin-top: 20px;
  }
  </style>
  