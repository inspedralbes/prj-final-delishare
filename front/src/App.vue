<template>
  <div id="app">
    <Navbar />
    <router-view></router-view> <!-- Este es el lugar donde se renderiza la vista activa -->
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';

export default {
  name: 'App',
  components: {
    Navbar,
  },
};
</script>

<style>
/* Aquí puedes agregar estilos globales, si es necesario */
</style>
