<template>
    <div v-if="recipe" class="recipe-container">
      <div class="recipe-header">
        <h1>{{ recipe.title }}</h1>
        <p class="recipe-description">{{ recipe.description }}</p>
      </div>
      
      <div class="recipe-image">
        <img :src="recipe.image" alt="Recipe Image" />
      </div>
  
      <div class="recipe-info">
        <div class="recipe-details">
          <h3>Ingredients:</h3>
          <ul>
            <li v-for="(ingredient, index) in recipe.ingredients" :key="index">{{ ingredient }}</li>
          </ul>
        </div>
        <div class="recipe-details">
          <h3>Steps:</h3>
          <ol>
            <li v-for="(step, index) in recipe.steps" :key="index">{{ step }}</li>
          </ol>
        </div>
  
        <div class="recipe-details">
          <h3>Preparation Time:</h3>
          <p>{{ recipe.prep_time }} minutes</p>
        </div>
  
        <div class="recipe-details">
          <h3>Cooking Time:</h3>
          <p>{{ recipe.cook_time }} minutes</p>
        </div>
  
        <div class="recipe-details">
          <h3>Servings:</h3>
          <p>{{ recipe.servings }} servings</p>
        </div>
  
        <div class="recipe-details">
          <h3>Nutrition:</h3>
          <p>Calories: {{ recipe.nutrition.calories }}</p>
          <p>Fat: {{ recipe.nutrition.fat }}g</p>
          <p>Protein: {{ recipe.nutrition.protein }}g</p>
        </div>
      </div>
  
      <!-- Edit, Copy, Delete buttons -->
      <div class="recipe-actions">
        <button @click="editRecipe">Edit</button>
        <button @click="copyRecipe">Copy</button>
        <button @click="deleteRecipe">Delete</button>
      </div>
    </div>
    <div v-else class="loading">Loading...</div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        recipe: null,
        recipeId: 1, // Este valor debe ser dinámico, dependiendo de la receta que desees mostrar
      };
    },
    async created() {
      try {
        const response = await fetch(`/api/recipes/${this.recipeId}`);
        if (response.ok) {
          const data = await response.json();
          this.recipe = data;
        } else {
          console.error('Error fetching recipe details:', response.statusText);
        }
      } catch (error) {
        console.error('Error fetching recipe details:', error);
      }
    },
    methods: {
      editRecipe() {
        // Lógica para editar la receta
        this.$router.push(`/edit-recipe/${this.recipe.id}`);
      },
      copyRecipe() {
        // Lógica para copiar la receta (puedes hacer algo como duplicar los campos y guardarlo como nueva receta)
        const copiedRecipe = { ...this.recipe, id: null }; // Creamos una copia sin ID
        // Luego puedes enviar esta copia a tu backend para guardarla como una nueva receta
        fetch('/api/recipes', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(copiedRecipe),
        })
          .then(response => response.json())
          .then(data => {
            console.log('Recipe copied successfully', data);
          })
          .catch(error => {
            console.error('Error copying recipe:', error);
          });
      },
      deleteRecipe() {
        // Lógica para eliminar la receta
        fetch(`/api/recipes/${this.recipe.id}`, {
          method: 'DELETE',
        })
          .then(() => {
            this.$router.push('/recipes'); // Redirige a la lista de recetas después de eliminar
          })
          .catch(error => {
            console.error('Error deleting recipe:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .recipe-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  }
  
  .recipe-header {
    text-align: center;
  }
  
  .recipe-header h1 {
    font-size: 2em;
    color: #333;
  }
  
  .recipe-description {
    font-size: 1.2em;
    color: #666;
  }
  
  .recipe-image {
    text-align: center;
    margin: 20px 0;
  }
  
  .recipe-image img {
    max-width: 100%;
    border-radius: 8px;
  }
  
  .recipe-info {
    margin-top: 20px;
  }
  
  .recipe-details {
    margin-bottom: 15px;
  }
  
  .recipe-details h3 {
    font-size: 1.2em;
    color: #358600;
  }
  
  .recipe-details ul,
  .recipe-details ol {
    margin: 0;
    padding: 0;
    list-style-type: none;
  }
  
  .recipe-details li {
    margin-bottom: 10px;
  }
  
  .recipe-actions {
    margin-top: 20px;
    display: flex;
    justify-content: space-around;
  }
  
  .recipe-actions button {
    background-color: #63c132;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }
  
  .recipe-actions button:hover {
    background-color: #358600;
  }
  
  .loading {
    text-align: center;
    font-size: 1.5em;
    color: #333;
  }
  </style>
  