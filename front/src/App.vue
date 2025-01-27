<template>
  <!-- Barra de navegación con links a distintas páginas -->
  <nav class="navbar">
    <ul>
      <!-- Botón de inicio (home) -->
      <li>
        <router-link to="/">
          <img src="/assets/images/homee.png" alt="Home" />
        </router-link>
      </li>
      <!-- Botón de búsqueda -->
      <li>
        <router-link to="/search">
          <img src="/assets/images/lupa.png" alt="Search" class="search-icon" />
        </router-link>
      </li>
      <!-- Botón para crear nuevo post -->
      <li>
        <button>
          <img src="/assets/images/mas.png" alt="Post" />
        </button>
      </li>
      <!-- Botón para recetas guardadas -->
      <li>
        <router-link to="/saved">
          <img src="/assets/images/guardar.png" alt="Saved" />
        </router-link>
      </li>
      <!-- Botón de perfil -->
      <li>
        <button>
          <img src="/assets/images/perfil.png" alt="Profile" />
        </button>
      </li>
    </ul>
  </nav>
  <div id="app">
    <!-- Vista para el componente de acuerdo a la ruta -->
    <router-view></router-view>
  </div>
</template>

<script>
// Este componente es responsable de mostrar la barra de navegación
export default {
  name: 'Navbar',
};
</script>

<style scoped>
/* Estilo para la barra de navegación */
.navbar {
  background-color: #343330;
  padding: 10px 0;
  text-align: center;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
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
  width: 30px;
  height: 30px;
  object-fit: contain;
}

.navbar button:hover img,
.navbar a:hover img {
  opacity: 0.8;
}
</style>
