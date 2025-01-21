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
  
  <style scoped>
  /* Estilos Generales */
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
    height: 300px;
  }
  
  .carousel-images {
    display: flex;
    transition: transform 0.5s ease-in-out;
  }
  
  .carousel-images img {
    width: 100%;
    height: 300px;
    object-fit: cover;
  }
  
  /* Recetas recientes */
  .recent-recipes {
    text-align: center;
    padding: 20px;
  }
  
  .recipe-grid {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
  }
  
  .recipe-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 200px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .recipe-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }
  
  .recipe-card p {
    margin: 0;
    padding: 10px;
    text-align: center;
    background-color: #f8f8f8;
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
  }
  
  .navbar ul li {
    display: inline;
    margin: 0 15px;
  }
  
  .navbar button {
    background-color: #ff6347;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .navbar button:hover {
    background-color: #e55347;
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
  </style>
  