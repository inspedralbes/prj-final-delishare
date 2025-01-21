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
  // Importa las imágenes directamente
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
        // Usar las imágenes importadas directamente
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
    background-color: #ff6347;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
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
  
    .navbar button {
      padding: 10px 20px;
      font-size: 16px;
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
  }
}
  </style>
  