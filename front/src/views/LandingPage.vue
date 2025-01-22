<template>
  <div>
    <!-- Header -->
    <header class="header">
      <h1>DeliShare</h1>
    </header>

    <!-- Carrusel de imágenes -->
    <div class="carousel">
      <div class="carousel-images" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
        <img v-for="(image, index) in carouselImages" :key="index" :src="image.src" :alt="image.alt">
      </div>
    </div>

    <!-- Recetas recientes -->
    <div class="recientes">
      <section class="recent-recipes">
        <h2>Recetas Recientes</h2>
        <div class="carousel-container">
          <button class="carousel-arrow left" @click="moveSlide('left', 'recent')">←</button>
          <div class="recipe-carousel">
            <div
              class="recipe-card"
              v-for="(recipe, index) in displayedRecentRecipes"
              :key="index"
            >
              <img :src="recipe.image" :alt="recipe.title" class="recipe-image">
              <div class="recipe-info">
                <p class="recipe-title">{{ recipe.title }}</p>
                <p class="recipe-description">{{ recipe.description }}</p>
              </div>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'recent')">→</button>
        </div>
      </section>
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
                <p class="recipe-description">{{ recipe.description }}</p>
              </div>
            </div>
          </div>
          <button class="carousel-arrow right" @click="moveSlide('right', 'likes')">→</button>
        </div>
      </section>
    </div>

    <!-- Botón de búsqueda -->
    <router-link to="/search">
      <img src="@/assets/images/lupa.png" alt="Buscar" class="search-icon" />
    </router-link>

    <!-- Navbar -->
    <nav class="navbar">
      <ul>
        <li><button><img src="@/assets/images/homee.png" alt="Home" /></button></li>
        <li><router-link to="/search"><img src="@/assets/images/lupa.png" alt="Search" class="search-icon" /></router-link></li>
        <li><button><img src="@/assets/images/mas.png" alt="Post" /></button></li>
        <li><button><img src="@/assets/images/guardar.png" alt="Saved" /></button></li>
        <li><button><img src="@/assets/images/perfil.png" alt="Profile" /></button></li>
      </ul>
    </nav>

    <!-- Footer -->
    <footer class="footer">
      <p>&copy; 2025 Recetas Deliciosas | Diseñado con amor</p>
      <p>Síguenos en <a href="#">Instagram</a></p>
    </footer>
  </div>
</template>

<script>
import comidaImg from '@/assets/images/comida.jpg';
import receta2Img from '@/assets/images/receta2.jpg';
import receta3Img from '@/assets/images/receta3.jpg';

export default {
  data() {
    return {
      currentSlide: 0,
      currentSlideRecent: 0,
      currentSlideLikes: 0,
      carouselImages: [
        { src: comidaImg, alt: 'Receta 1' },
        { src: receta2Img, alt: 'Receta 2' },
        { src: receta3Img, alt: 'Receta 3' },
      ],
      recipes: [], // Inicializa un array vacío para las recetas
      displayedRecentRecipes: [],
      displayedLikeRecipes: [],
      recipesToShow: 5, // Mostrar 5 recetas
    };
  },
  mounted() {
    // Cargar los datos del archivo JSON usando fetch
    fetch('/data.json') // Ruta relativa al archivo data.json en public
      .then(response => response.json())
      .then(data => {
        this.recipes = data.recipes; // Asigna las recetas desde el JSON
        this.displayedRecentRecipes = this.recipes.slice(0, this.recipesToShow);
        this.displayedLikeRecipes = this.recipes.slice(0, this.recipesToShow);
      })
      .catch(error => {
        console.error("Error loading data.json:", error);
      });

    this.startCarousel();
  },
  methods: {
    startCarousel() {
      setInterval(() => {
        this.currentSlide = (this.currentSlide + 1) % this.carouselImages.length;
      }, 3000); // Cambia cada 3 segundos
    },
    moveSlide(direction, type) {
      if (type === 'recent') {
        if (direction === 'left') {
          this.currentSlideRecent = Math.max(0, this.currentSlideRecent - 1); // Previene que vaya negativo
        } else {
          this.currentSlideRecent = Math.min(this.recipes.length - this.recipesToShow, this.currentSlideRecent + 1); // Evita ir más allá del final
        }
      } else if (type === 'likes') {
        if (direction === 'left') {
          this.currentSlideLikes = Math.max(0, this.currentSlideLikes - 1);
        } else {
          this.currentSlideLikes = Math.min(this.recipes.length - this.recipesToShow, this.currentSlideLikes + 1);
        }
      }

      this.updateDisplayedRecipes(type);
    },

    updateDisplayedRecipes(type) {
      if (type === 'recent') {
        const startIndex = this.currentSlideRecent;
        this.displayedRecentRecipes = this.recipes.slice(startIndex, startIndex + this.recipesToShow);
      } else if (type === 'likes') {
        const startIndex = this.currentSlideLikes;
        this.displayedLikeRecipes = this.recipes.slice(startIndex, startIndex + this.recipesToShow);
      }
    },
  },
};
</script>

<style scoped>
/* Mobile-First Styles (Optimizado para móviles por defecto) */

/* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.header {
  background-color: #ff6347;
  color: white;
  text-align: center;
  padding: 20px 0;
}

/* Carrusel */
.carousel {
  position: relative;
  overflow: hidden;
  height: 200px; /* Ajuste para móviles */
}

.carousel-images {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.carousel-images img {
  width: 100%;
  height: 200px; /* Ajuste para móviles */
  object-fit: cover;
}

/* Recetas recientes y más likes */
.carousel-container {
  display: flex;
  align-items: center;
  position: relative;
  justify-content: center;
}

.recipe-carousel {
  display: flex;
  overflow: hidden;
  width: 100%;
}

.recipe-card {
  margin: 0 15px; /* Margen entre las tarjetas */
  width: 150px; /* Ancho de tarjeta pequeño */
  height: 220px; /* Altura ajustada */
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.recipe-image {
  width: 100%;
  height: 130px; /* Imagen más pequeña */
  object-fit: cover;
}

.recipe-info {
  padding: 10px;
  background-color: #f8f8f8;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.recipe-title {
  font-weight: bold;
  font-size: 14px;
  margin-bottom: 8px;
}

.recipe-description {
  font-size: 12px;
  color: #555;
  flex-grow: 1;
}

/* Flechas de navegación */
.carousel-arrow {
  background-color: transparent;
  border: none;
  font-size: 2em;
  cursor: pointer;
  color: #ff6347;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.carousel-arrow.left {
  left: 10px;
}

.carousel-arrow.right {
  right: 10px;
}

/* Navbar */
.navbar {
  background-color: #333;
  padding: 10px 0;
  text-align: center;
}

.navbar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: space-around;
}

.navbar button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  padding: 0;
}

.navbar img {
  width: 25px;
  height: 25px;
}

.navbar button:hover img {
  opacity: 0.8;
}

/* Footer */
.footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 10px 0;
}

.footer a {
  color: #ff6347;
  text-decoration: none;
}

/* Media Queries para Pantallas Más Grandes */
@media (min-width: 768px) {
  .carousel {
    height: 300px;
  }

  .carousel-images img {
    height: 300px;
  }

  .recipe-carousel {
    width: 80%;
  }

  .recipe-card {
    width: 180px;
    height: 250px;
  }

  .recipe-image {
    height: 150px;
  }
}

@media (min-width: 1024px) {
  .carousel {
    height: 400px;
  }

  .carousel-images img {
    height: 400px;
  }

  .recipe-carousel {
    width: 70%;
  }

  .recipe-card {
    width: 220px;
    height: 280px;
  }

  .recipe-image {
    height: 180px;
  }
}
</style>
