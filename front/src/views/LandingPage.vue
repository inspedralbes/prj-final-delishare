<template>
  <div class="page-container">
    <!-- Header -->
    <header class="header">
      <img src="@/assets/images/delishare-logo.jpg" alt="DeliShare Logo" class="header-logo">
    </header>

    <!-- Carrusel de imágenes -->
    <div class="carousel">
      <div class="carousel-images" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
        <img v-for="(image, index) in carouselImages" :key="index" :src="image.src" :alt="image.alt">
      </div>
    </div>

    <!-- Recetas más likes -->
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
              <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
              <div class="recipe-info">
                <p class="recipe-title">{{ recipe.title }}</p>
              </div>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'likes')">→</button>
        </div>
      </section>
    </div>

    <!-- Recetas más recientes -->
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
              <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
              <div class="recipe-info">
                <p class="recipe-title">{{ recipe.title }}</p>
              </div>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'recents')">→</button>
        </div>
      </section>
    </div>

  </div>
</template>

<script>
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
      carouselImages: [
        { src: 'https://example.com/spaghetti.jpg', alt: 'Spaghetti Carbonara' },
        { src: 'https://example.com/chicken-curry.jpg', alt: 'Chicken Curry' },
        { src: 'https://example.com/vegetable-stir-fry.jpg', alt: 'Vegetable Stir Fry' }
      ]
    };
  },
  async created() {
    try {
      // Cargar recetas desde el archivo JSON
      const response = await fetch('/data.json'); // Asumiendo que data.json está en public
      const data = await response.json();
      this.recipes = data;

      // Ordenar por likes
      this.sortedLikeRecipes = this.recipes
        .map(recipe => ({
          ...recipe,
          totalLikes: recipe.likes_count || 0
        }))
        .sort((a, b) => b.totalLikes - a.totalLikes)
        .slice(0, this.totalRecipesToShow);

      // Ordenar por fecha más reciente (asumiendo que `created_at` está en formato ISO)
      this.sortedRecentRecipes = [...this.recipes]
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, this.totalRecipesToShow);

      this.updateDisplayedLikeRecipes();
      this.updateDisplayedRecentRecipes();
    } catch (error) {
      console.error('Error fetching recipes from the backend:', error);
    }

    this.startCarousel();
  },
  methods: {
    startCarousel() {
      setInterval(() => {
        this.currentSlide = (this.currentSlide + 1) % this.carouselImages.length;
      }, 3000);
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
  },
};
</script>

<style scoped>
/* Mantengo el CSS igual que lo pediste */

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
  color: #333;
  font-size: 24px;
  margin-bottom: 15px;
}

.header-logo {
  display: block;
  margin: 0 auto;
  width: 150px;
}
</style>
