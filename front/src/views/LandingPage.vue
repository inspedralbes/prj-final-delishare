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
      <section class="recent-recipes">
        <h2>Recetas Recientes</h2>
        <div class="recipe-grid">
          <div class="recipe-card" v-for="(recipe, index) in recentRecipes" :key="index">
            <img :src="recipe.image" :alt="recipe.title">
            <p>{{ recipe.title }}</p>
          </div>
        </div>
      </section>
  
      <!-- Navbar -->
      <nav class="navbar">
        <ul>
          <li><button>a</button></li>
          <li><button>lupa</button></li>
          <li><button>post</button></li>
          <li><button>saved</button></li>
          <li><button>yo</button></li>
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
  export default {
    data() {
      return {
        currentSlide: 0,
        carouselImages: [
          { src: "receta1.jpg", alt: "Receta 1" },
          { src: "receta2.jpg", alt: "Receta 2" },
          { src: "receta3.jpg", alt: "Receta 3" },
        ],
        recentRecipes: [
          { image: "reciente1.jpg", title: "Receta reciente 1" },
          { image: "reciente2.jpg", title: "Receta reciente 2" },
          { image: "reciente3.jpg", title: "Receta reciente 3" },
        ],
      };
    },
    mounted() {
      this.startCarousel();
    },
    methods: {
      startCarousel() {
        setInterval(() => {
          this.currentSlide = (this.currentSlide + 1) % this.carouselImages.length;
        }, 3000); // Cambia cada 3 segundos
      },
    },
  };
  </script>
  
 
  