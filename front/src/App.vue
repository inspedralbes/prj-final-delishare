<template>
  <div id="app">
    <router-view></router-view>  <!-- Este es el lugar donde se renderiza la vista activa -->
  </div>
</template>

<script>
import { useAuthStore } from './stores/useAuthStore';

export default {
  name: 'App'
}
</script>

<style>

</style>
