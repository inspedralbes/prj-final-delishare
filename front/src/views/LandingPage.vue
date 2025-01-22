<template>
  <div class="page-container">
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

    <!-- Navbar -->
    <Navbar />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue'; // Asegúrate de que la ruta sea correcta
import comidaImg from '@/assets/images/comida.jpg';
import receta2Img from '@/assets/images/receta2.jpg';
import receta3Img from '@/assets/images/receta3.jpg';

export default {
  components: {
    Navbar, // Registramos el componente Navbar
  },
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
      recipes: [],
      displayedRecentRecipes: [],
      displayedLikeRecipes: [],
      recipesToShow: 3, // Mostrar solo 5 recetas inicialmente
    };
  },
  mounted() {
    fetch('/data.json')
      .then(response => response.json())
      .then(data => {
        this.recipes = data.recipes;
        // Inicializamos las recetas mostradas
        this.displayedRecentRecipes = this.recipes.slice(0, this.recipesToShow);
        // Filtrar las recetas con más likes
        this.displayedLikeRecipes = this.recipes.filter(recipe => recipe.liked).slice(0, this.recipesToShow);
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
      }, 3000);
    },
    moveSlide(direction, type) {
      if (type === 'recent') {
        if (direction === 'left') {
          this.currentSlideRecent = Math.max(0, this.currentSlideRecent - 1);
        } else {
          this.currentSlideRecent = Math.min(this.recipes.length - this.recipesToShow, this.currentSlideRecent + 1);
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
        this.displayedLikeRecipes = this.recipes.filter(recipe => recipe.liked).slice(startIndex, startIndex + this.recipesToShow);
      }
    },
  },
};
</script>

<style scoped>
/* Estilos Generales para Móviles */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Asegura que el cuerpo ocupe al menos toda la altura de la pantalla */
}

/* Contenedor principal para asegurar que el navbar esté al final */
.page-container {
  display: flex;
  flex-direction: column;
  flex-grow: 1; /* El contenedor crece para llenar el espacio disponible */
}

/* Carrusel de imágenes */
.carousel {
  position: relative;
  overflow: hidden;
  height: 220px; /* Altura fija para el carrusel */
}

.carousel-images {
  display: flex;
  transition: transform 0.5s ease-in-out;
}

.carousel-images img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 8px;
}

/* Recetas recientes y más likes */
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
  width: calc(100% - 50px); /* Reducimos el tamaño para dejar espacio para las flechas */
}

.recipe-card {
  margin: 0 6px; /* Reducir el espacio entre los cards */
  width: 100%; /* Para mantener las cartas del mismo tamaño */
  max-width: 100px; /* Limitar el ancho de cada card */
  height: 100px; /* Altura fija para las tarjetas */
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: transform 0.3s ease-in-out;
  font-size: 10px; /* Reducir tamaño de texto dentro del card */
}

.recipe-card:hover {
  transform: scale(1.05);
}

.recipe-image {
  width: 100%;
  height: 60%; /* La imagen ocupa el 60% del card */
  object-fit: cover;
}

.recipe-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 40%; /* Mantener el espacio para el título */
}

.recipe-title {
  font-weight: bold;
  font-size: 12px; /* Aumentar el tamaño del título */
  color: #333;
  text-align: center;
}

/* Flechas de navegación */
.carousel-arrow {
  background-color: transparent;
  border: none;
  font-size: 1em; /* Reducir el tamaño de las flechas */
  cursor: pointer;
  color: #FF6F61;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.carousel-arrow.left {
  left: 0; /* Pegar la flecha al borde izquierdo */
}

.carousel-arrow.right {
  right: 0; /* Pegar la flecha al borde derecho */
}

</style>
