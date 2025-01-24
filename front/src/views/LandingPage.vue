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
  
      <!-- Botón de búsqueda que es la imagen de la lupa, redirige a SearchPage -->
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
  import reciente1Img from '@/assets/images/reciente1.jpg';
  import reciente2Img from '@/assets/images/reciente2.jpg';
  import reciente3Img from '@/assets/images/reciente3.jpg';
  
  export default {
    data() {
      return {
        currentSlide: 0,
        carouselImages: [
          { src: comidaImg, alt: 'Receta 1' },
          { src: receta2Img, alt: 'Receta 2' },
          { src: receta3Img, alt: 'Receta 3' },
        ],
        recentRecipes: [
          { image: reciente1Img, title: 'Receta reciente 1' },
          { image: reciente2Img, title: 'Receta reciente 2' },
          { image: reciente3Img, title: 'Receta reciente 3' },
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
  
  /* Recetas recientes */
  .recent-recipes {
    text-align: center;
    padding: 20px;
  }
  
  .recipe-grid {
    display: grid;
    grid-template-columns: 1fr; /* Una columna en móviles */
    gap: 20px;
  }
  
  .recipe-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .recipe-card img {
    width: 100%;
    height: auto; /* Mantener proporción */
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
    display: flex;
    justify-content: space-around; /* Espaciado uniforme */
  }
  
  .navbar button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
  }
  
  .navbar img {
    width: 30px;
    height: 30px;
    object-fit: contain;
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
  
  /* Estilos para pantallas más grandes */
  @media (min-width: 768px) {
    .carousel {
      height: 300px; /* Tamaño mayor para tablets */
    }
  
    .carousel-images img {
      height: 300px;
    }
  
    .recipe-grid {
      grid-template-columns: repeat(2, 1fr); /* Dos columnas en tablets */
    }
  
    .navbar img {
      width: 40px;
      height: 40px;
    }
  }
  
  @media (min-width: 1024px) {
    .recipe-grid {
      grid-template-columns: repeat(3, 1fr); /* Tres columnas en pantallas grandes */
    }
  
    .carousel {
      height: 400px; /* Tamaño mayor para desktops */
    }
  
    .carousel-images img {
      height: 400px;
    }
  
    .navbar img {
      width: 50px;
      height: 50px;
    }
  }
  
  /* Estilos específicos para el icono de búsqueda */
  .search-icon {
    width: 30px;
    height: 30px;
    cursor: pointer;
  }
  </style>
  