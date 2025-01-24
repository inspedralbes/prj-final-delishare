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

    <!-- Navbar -->
    <Navbar />
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue';
import comidaImg from '@/assets/images/comida.jpg';
import receta2Img from '@/assets/images/receta2.jpg';
import receta3Img from '@/assets/images/receta3.jpg';

export default {
  components: {
    Navbar,
  },
  data() {
    return {
      currentSlide: 0,
      currentSlideLikes: 0,
      currentSlideRecents: 0,
      carouselImages: [
        { src: comidaImg, alt: 'Receta 1' },
        { src: receta2Img, alt: 'Receta 2' },
        { src: receta3Img, alt: 'Receta 3' },
      ],
      recipes: [],
      sortedLikeRecipes: [], // Recetas ordenadas por likes
      sortedRecentRecipes: [], // Recetas ordenadas por fecha más reciente
      displayedLikeRecipes: [], // Recetas visibles en "Más Likes"
      displayedRecentRecipes: [], // Recetas visibles en "Más Recientes"
      recipesPerPage: 3,
      totalRecipesToShow: 9,
    };
  },
  mounted() {
    fetch('/data.json')
      .then(response => response.json())
      .then(data => {
        this.recipes = data.recipes;

        // Recetas más likes
        this.sortedLikeRecipes = this.recipes
          .map(recipe => ({
            ...recipe,
            totalLikes: recipe.liked.reduce((a, b) => a + b, 0), // Sumar likes
          }))
          .sort((a, b) => b.totalLikes - a.totalLikes)
          .slice(0, this.totalRecipesToShow);

        // Recetas más recientes
        this.sortedRecentRecipes = [...this.recipes]
          .sort((a, b) => new Date(b.date) - new Date(a.date)) // Ordenar por fecha descendente
          .slice(0, this.totalRecipesToShow);

        // Inicializar las recetas visibles
        this.updateDisplayedLikeRecipes();
        this.updateDisplayedRecentRecipes();
      })
      .catch(error => {
        console.error('Error loading data.json:', error);
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
/* Estilos base para dispositivos móviles (Mobile-first) */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
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
  border-radius: 8px;
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
}

.recipe-card {
  margin: 0 6px;
  width: 100%;
  max-width: 100px;
  height: 100px;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: transform 0.3s ease-in-out;
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
  color: #333;
  text-align: center;
}

.carousel-arrow {
  background-color: transparent;
  border: none;
  font-size: 1em;
  cursor: pointer;
  color: #FF6F61;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.carousel-arrow.left {
  left: 0;
}

.carousel-arrow.right {
  right: 0;
}

/* Estilo para añadir espacio entre las recetas recientes y el navbar */
.recents {
  margin-bottom: 20px;
}

/* Media Query para pantallas más grandes (Tablets y Desktops) */
@media (min-width: 768px) {
  /* Ajustar el tamaño de la imagen del carrusel */
  .carousel-images img {
    height: 300px;
  }

  /* Ajustar el tamaño de las tarjetas de recetas */
  .recipe-card {
    max-width: 150px;
    height: 150px;
    font-size: 14px;
  }

  .recipe-title {
    font-size: 14px;
  }

  /* Hacer las flechas del carrusel un poco más grandes */
  .carousel-arrow {
    font-size: 1.5em;
  }
}

/* Media Query para pantallas de escritorio más grandes (Desktops y Monitores grandes) *//* Media Query para pantallas de escritorio más grandes (Desktops y Monitores grandes) */
/* Media Query para pantallas de escritorio más grandes (Desktops y Monitores grandes) *//* Media Query para pantallas de escritorio más grandes (Desktops y Monitores grandes) */
@media (min-width: 1024px) {
  /* Ajustar el tamaño de la imagen del carrusel */
  .carousel-images img {
    height: 450px; /* Un poco más alto para hacerlo más impactante */
  }

  /* Ajustar el tamaño de las tarjetas de recetas */
  .recipe-card {
    max-width: 350px; /* Hacer las tarjetas un poco más grandes */
    height: 350px;
    font-size: 18px; /* Mejorar la legibilidad */
  }

  .recipe-title {
    font-size: 18px; /* Aumentar el tamaño de la fuente del título */
  }

  /* Mejorar la visibilidad de las flechas del carrusel */
  .carousel-arrow {
    font-size: 2.5em; /* Aumentar tamaño para mejor acceso */
    padding: 10px; /* Añadir algo de padding para hacer los botones más accesibles */
  }

  /* Asegurarse de que los márgenes entre los elementos sean coherentes */
  .recipe-carousel {
    gap: 15px; /* Añadir espacio entre las tarjetas para una mejor distribución */
    justify-content: center; /* Centrar las tarjetas en el contenedor */
  }

  /* Mejorar el espaciado del contenedor de las recetas recientes */
  .recents {
    margin-bottom: 40px; /* Asegurar más espacio hacia el final de la sección */
  }

  /* Hacer el título "DeliShare" más grande y centrado */
  .header h1 {
    font-size: 3.5em; /* Aumentar tamaño del título */
    text-align: center; /* Centrar el título */
    margin: 30px 0; /* Añadir espacio superior e inferior */
  }

  /* Centrar el contenedor de las tarjetas de recetas */
  .carousel-container {
    display: flex;
    align-items: center;
    position: relative;
    justify-content: center; /* Asegurarse de que todo esté centrado */
    width: 100%;
  }
}


</style>

