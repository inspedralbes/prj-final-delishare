<template>
  <div class="page-container">
    <!-- Header -->
    <header class="header">
      <img src="@/assets/images/delishare-logo.jpg" alt="DeliShare Logo" class="header-logo">
    </header>

    <!-- Carrusel de imágenes -->
    <div class="carousel">
      <div class="carousel-images" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
        <img v-for="(image, index) in carouselImages" 
             :key="index" 
             v-show="currentSlide === index" 
             :src="image.src" 
             :alt="image.alt">
      </div>
      <button class="carousel-arrow left" @click="moveSlide('left')">←</button>
      <button class="carousel-arrow right" @click="moveSlide('right')">→</button>
    </div>

    <!-- Recetas más likes y más recientes -->
    <div class="likes">
      <section class="recent-recipes">
        <h2>Más Likes</h2>
        <div class="carousel-container">
          <button class="carousel-arrow left" @click="moveSlide('left', 'likes')">←</button>
          <div class="recipe-carousel">
            <div
              class="recipe-card"
              v-for="(recipe, index) in displayedLikeRecipes"
              :key="index"
            >
              <!-- Enlace a la página de detalles de la receta -->
              <router-link :to="{ name: 'InfoReceta', params: { recipeId: recipe.id } }" class="recipe-link">
                <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
                <div class="recipe-info">
                  <p class="recipe-title">{{ recipe.title }}</p>
                </div>
              </router-link>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'likes')">→</button>
        </div>
      </section>
    </div>

    <div class="recents">
      <section class="recent-recipes">
        <h2>Más Recientes</h2>
        <div class="carousel-container">
          <button class="carousel-arrow left" @click="moveSlide('left', 'recents')">←</button>
          <div class="recipe-carousel">
            <div
              class="recipe-card"
              v-for="(recipe, index) in displayedRecentRecipes"
              :key="index"
            >
              <!-- Enlace a la página de detalles de la receta -->
              <router-link :to="{ name: 'InfoReceta', params: { recipeId: recipe.id } }" class="recipe-link">
                <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
                <div class="recipe-info">
                  <p class="recipe-title">{{ recipe.title }}</p>
                </div>
              </router-link>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'recents')">→</button>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
// Importación estática de imágenes
import img1 from '@/assets/images/receta1.jpg';
import img2 from '@/assets/images/receta2.jpg';
import img3 from '@/assets/images/receta3.jpg';

import communicationManager from '@/components/services/communicationManager';

export default {
  data() {
    return {
      currentSlide: 0,
      currentSlideLikes: 0,
      currentSlideRecents: 0,
      recipes: [],
      sortedLikeRecipes: [],
      sortedRecentRecipes: [],
      displayedLikeRecipes: [],
      displayedRecentRecipes: [],
      recipesPerPage: 3,
      totalRecipesToShow: 9,
      // Usar las imágenes de las recetas
      carouselImages: [
        { src: img1, alt: 'Imagen de Receta 1' },
        { src: img2, alt: 'Imagen de Receta 2' },
        { src: img3, alt: 'Imagen de Receta 3' }
      ]
    };
  },

  async created() {
    try {
      // Cargar recetas desde el backend
      const data = await communicationManager.fetchRecipes();
      this.recipes = data;

      // Ordenar por likes
      this.sortedLikeRecipes = this.recipes
        .map(recipe => ({
          ...recipe,
          totalLikes: recipe.likes_count || 0,
        }))
        .sort((a, b) => b.totalLikes - a.totalLikes)
        .slice(0, this.totalRecipesToShow);

      // Ordenar por fecha más reciente
      this.sortedRecentRecipes = [...this.recipes]
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, this.totalRecipesToShow);

      // Asignar imágenes aleatorias a todas las recetas
      this.randomizeImages();

      // Actualizar las recetas que se mostrarán
      this.updateDisplayedLikeRecipes();
      this.updateDisplayedRecentRecipes();

      // Mezclar las imágenes del carrusel
      this.shuffleCarouselImages();
    } catch (error) {
      console.error('Error fetching recipes from the backend:', error);
    }

    this.startCarousel();
  },

  methods: {
    // Método para mezclar las imágenes del carrusel
    shuffleCarouselImages() {
      for (let i = this.carouselImages.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [this.carouselImages[i], this.carouselImages[j]] = [this.carouselImages[j], this.carouselImages[i]];
      }
    },

    // Método para asignar imágenes aleatorias a todas las recetas
    randomizeImages() {
      this.recipes.forEach(recipe => {
        // Seleccionar una imagen aleatoria de las imágenes disponibles para la receta
        const randomImage = [img1, img2, img3][Math.floor(Math.random() * 3)];
        recipe.image = randomImage;  // Asegúrate de que la receta tiene la imagen asignada
      });
    },

    startCarousel() {
      setInterval(() => {
        this.moveSlide('right');  // Mueve la imagen automáticamente cada 3 segundos
      }, 3000);
    },
    
    moveSlide(direction) {
      if (direction === 'left') {
        this.currentSlide = (this.currentSlide - 1 + this.carouselImages.length) % this.carouselImages.length;
      } else if (direction === 'right') {
        this.currentSlide = (this.currentSlide + 1) % this.carouselImages.length;
      }
    },

    moveSlide(direction, type) {
      if (type === 'likes') {
        const maxSlideIndex = Math.ceil(this.sortedLikeRecipes.length / this.recipesPerPage) - 1;
        if (direction === 'left') {
          this.currentSlideLikes = Math.max(0, this.currentSlideLikes - 1);
        } else {
          this.currentSlideLikes = Math.min(maxSlideIndex, this.currentSlideLikes + 1);
        }
        this.updateDisplayedLikeRecipes();
      } else if (type === 'recents') {
        const maxSlideIndex = Math.ceil(this.sortedRecentRecipes.length / this.recipesPerPage) - 1;
        if (direction === 'left') {
          this.currentSlideRecents = Math.max(0, this.currentSlideRecents - 1);
        } else {
          this.currentSlideRecents = Math.min(maxSlideIndex, this.currentSlideRecents + 1);
        }
        this.updateDisplayedRecentRecipes();
      }
    },

    updateDisplayedLikeRecipes() {
      const startIndex = this.currentSlideLikes * this.recipesPerPage;
      this.displayedLikeRecipes = this.sortedLikeRecipes.slice(
        startIndex,
        startIndex + this.recipesPerPage
      );
    },

    updateDisplayedRecentRecipes() {
      const startIndex = this.currentSlideRecents * this.recipesPerPage;
      this.displayedRecentRecipes = this.sortedRecentRecipes.slice(
        startIndex,
        startIndex + this.recipesPerPage
      );
    },
  }
};
</script>



<style scoped>
/* Estilos iguales al código anterior */
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

.carousel {
  position: relative;
  overflow: hidden;
  height: 220px;
}

.carousel-images {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.carousel-images img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.carousel-container {
  display: flex;
  align-items: center;
  position: relative;
  justify-content: center;
  width: 100%;
}

.recipe-carousel {
  display: flex;
  overflow: hidden;
  width: calc(100% - 50px);
  margin-bottom: 20px;
  align-items: center;
}

.recipe-card {
  margin: 0 6px;
  width: 100%;
  max-width: 100px;
  height: 100px;
  border: 1px solid #343330;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out, background-color 0.3s;
  font-size: 10px;
}

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
  font-size: 12px;
  color: #343330;
  text-align: center;
}

.carousel-arrow {
  background-color: transparent;
  border: none;
  font-size: 1em;
  cursor: pointer;
  color: #63c132;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.carousel-arrow:hover {
  color: #358600;
}

.carousel-arrow.left {
  left: 0;
}

.carousel-arrow.right {
  right: 0;
}

h2 {
  text-align: center;
  color: #358600;
  font-size: 1.5em;
  margin-bottom: 20px;
}

.recents {
  margin-bottom: 40px;
}

.recents .recipe-card {
  margin-bottom: 20px;
}

.likes .recipe-card {
  margin-bottom: 0;
}

.recipe-link {
  text-decoration: none;
  color: inherit;
  display: block;
  width: 100%;
  height: 100%;
}

@media (min-width: 768px) {
  .carousel-images img {
    height: 300px;
  }

  .recipe-card {
    max-width: 150px;
    height: 150px;
    font-size: 14px;
  }

  .recipe-title {
    font-size: 14px;
  }

  .carousel-arrow {
    font-size: 1.5em;
  }
}

@media (min-width: 1024px) {
  .carousel-images img {
    height: 450px;
  }

  .recipe-card {
    max-width: 350px;
    height: 350px;
    font-size: 18px;
  }

  .recipe-title {
    font-size: 18px;
  }

  .carousel-arrow {
    font-size: 2.5em;
    padding: 10px;
  }

  .recipe-carousel {
    gap: 15px;
    justify-content: center;
  }

  .recents {
    margin-bottom: 40px;
  }

  .header-logo {
    max-width: 100%;
    height: auto;
    max-height: 120px;
    display: block;
  }

  .carousel-container {
    display: flex;
    align-items: center;
    position: relative;
    justify-content: center;
    width: 100%;
  }
}
</style>