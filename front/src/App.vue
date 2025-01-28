<template>
  <nav class="navbar">
    <ul>
      <li><router-link to="/"><img src="../public/img/house.svg" alt="Home"  /></router-link></li>
      <li><router-link to="/search"><img src="../public/img/search.svg" alt="Search" class="search-icon" /></router-link></li>

      <li><button><img src="../public/img/plus-circle.svg" alt="Post" /></button></li>
      <li><button><img src="../public/img/bookmark.svg" alt="Saved" /></button></li>
      <li><router-link to="/profile"><img src="../public/img/person-circle.svg" alt="Profile" /></router-link></li>
    </ul>
  </nav>
  <div id="app">
    <router-view></router-view>  <!-- Este es el lugar donde se renderiza la vista activa -->
  </div>
</template>

<script>
import { useAuthStore } from './stores/useAuthStore';

export default {
  name: 'Navbar',
};

</script>

<style scoped>
.navbar {
  background-color: #343330;
  padding: 10px 0;
  text-align: center;
  position: fixed; /* Fija el navbar */
  bottom: 0; /* Lo posiciona en la parte inferior */
  left: 0;
  width: 100%; /* Asegura que ocupe todo el ancho */
  z-index: 1000; /* Lo coloca por encima de otros elementos */
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
</style>

